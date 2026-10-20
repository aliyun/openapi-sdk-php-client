<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;

class RequestDiagnosticsTest extends TestCase
{
    public static function protocols()
    {
        return [['rpc', 'GET'], ['rpc', 'POST'], ['roa', 'POST']];
    }

    /** @dataProvider protocols */
    public function testLogsAndDebugPreserveMessages($protocol, $method)
    {
        $logger = $this->reset();
        AlibabaCloud::setLogFormat('{request} {response} {req_header_Authorization} {req_header_x-acs-security-token}');
        $debug = fopen('php://temp', 'w+');
        $body = ['MessageTokenDTO' => ['AccessKeySecret' => 'issued-secret+/=', 'SecurityToken' => 'issued-token+/=']];
        AlibabaCloud::mockResponse(200, [], $body);
        $request = $protocol === 'rpc' ? AlibabaCloud::rpc()->action('DescribeRegions') : AlibabaCloud::roa();
        $result = $request->client('diagnostics')->host('example.test')->regionId('cn-hangzhou')->version('2020-01-01')
            ->method($method)->options(['debug' => $debug, 'query' => ['Echo' => 'request-secret+/=']])->request();
        rewind($debug);
        $output = implode("\n", $logger->messages) . stream_get_contents($debug);
        $message = AlibabaCloud::getHistory()[0]['request'];
        parse_str($method === 'POST' && $protocol === 'rpc' ? (string)$message->getBody() : $message->getUri()->getQuery(), $parameters);
        $signature = $protocol === 'rpc' ? $parameters['Signature'] : $message->getHeaderLine('Authorization');
        $this->assertRedacted($output, ['request-secret+/=', 'request-token+/=', 'issued-secret+/=', 'issued-token+/=', $signature]);
        self::assertStringContainsString('[REDACTED]', $output);
        self::assertSame($body, $result->toArray());
        if ($protocol === 'rpc') {
            self::assertSame('request-token+/=', $parameters['SecurityToken']);
            self::assertSame('request-secret+/=', $parameters['Echo']);
        } else {
            self::assertSame('request-token+/=', $message->getHeaderLine('x-acs-security-token'));
        }
        fclose($debug);
        $this->finish();
    }

    public static function requestModes()
    {
        return [[false], [true]];
    }

    /** @dataProvider requestModes */
    public function testTransportExceptionsDoNotRetainUnsafePrevious($async)
    {
        $logger = $this->reset();
        AlibabaCloud::setLogFormat('{error} {uri}');
        $request = $this->rpc();
        $request->resolveOption();
        $signature = $request->options['query']['Signature'];
        $message = 'failure request-secret+/= request-token+/= Signature=' . rawurlencode($signature);
        AlibabaCloud::mockRequestException(
            $message,
            new Request('GET', 'https://example.test/?Signature=' . rawurlencode($signature)),
            null,
            new \RuntimeException('unsafe previous request-secret+/=')
        );
        try {
            if ($async) {
                $request->requestAsync()->wait();
            } else {
                $request->request();
            }
            self::fail('Expected a transport exception');
        } catch (ClientException $exception) {
            $this->assertRedacted($exception->getMessage() . $exception->getErrorMessage() . implode('', $logger->messages), [
                'request-secret+/=', 'request-token+/=', $signature
            ]);
            self::assertNull($exception->getPrevious());
        }
        $this->finish();
    }

    public function testServerExceptionRedactsCredentialBodyAndKeepsResult()
    {
        $this->reset();
        $body = ['MessageTokenDTO' => ['AccessKeySecret' => 'issued-secret+/=', 'SecurityToken' => 'issued-token+/=']];
        AlibabaCloud::mockResponse(400, [], $body);
        try {
            $this->rpc()->request();
            self::fail('Expected a server exception');
        } catch (ServerException $exception) {
            $this->assertRedacted($exception->getMessage() . $exception->getErrorMessage(), ['issued-secret+/=', 'issued-token+/=']);
            self::assertSame($body, $exception->getResult()->toArray());
        }
        $this->finish();
    }

    public function testUnresolvedRequestCanBeRedactedWithoutCredentials()
    {
        AlibabaCloud::flush();
        $request = new RpcRequest();
        self::assertSame('SecurityToken=[REDACTED]', $request->redact('SecurityToken=unknown-token'));
        $result = new Result(new Response(400, [], '{"SecurityToken":"unknown-token"}'), $request);
        $exception = new ServerException($result);
        self::assertStringNotContainsString('unknown-token', $exception->getMessage());
        self::assertSame([], AlibabaCloud::all());
    }

    public function testMetadataDebugAndCredentialResponse()
    {
        $logger = $this->reset();
        AlibabaCloud::setLogFormat('{response}');
        $body = ['AccessKeySecret' => 'metadata-secret', 'SecurityToken' => 'metadata-token'];
        AlibabaCloud::mockResponse(200, [], $body);
        $result = RpcRequest::createClient()->request('GET', 'http://example.test/metadata');
        self::assertSame($body, $result->toArray());
        $this->assertRedacted(implode('', $logger->messages), ['metadata-secret', 'metadata-token']);
        $this->finish();
    }

    public function testCustomResponseHeaderFormatsAreRedacted()
    {
        $logger = $this->reset();
        AlibabaCloud::setLogFormat('{res_header_SecurityToken} {res_header_AccessKeySecret} {res_header_Authorization}');
        $headers = [
            'SecurityToken' => 'response-token+/= & tail; spaces',
            'AccessKeySecret' => 'response-secret+/= & tail; spaces',
            'Authorization' => 'acs key:response-signature+/='
        ];
        AlibabaCloud::mockResponse(200, $headers, '{}');
        $result = $this->rpc()->request();
        self::assertSame('[REDACTED] [REDACTED] [REDACTED]', implode('', $logger->messages));
        foreach ($headers as $name => $value) {
            self::assertSame($value, $result->getHeaderLine($name));
        }
        $this->finish();
    }

    private function rpc()
    {
        return AlibabaCloud::rpc()->client('diagnostics')->host('example.test')->regionId('cn-hangzhou')
            ->version('2020-01-01')->action('DescribeRegions');
    }

    private function reset()
    {
        AlibabaCloud::flush();
        AlibabaCloud::cancelMock();
        AlibabaCloud::forgetHistory();
        AlibabaCloud::rememberHistory();
        AlibabaCloud::stsClient('test-key', 'request-secret+/=', 'request-token+/=')->name('diagnostics');
        $logger = new DiagnosticsLogger();
        AlibabaCloud::setLogger($logger);
        return $logger;
    }

    private function finish()
    {
        AlibabaCloud::cancelMock();
        AlibabaCloud::notRememberHistory();
        AlibabaCloud::setLogFormat(null);
        $property = new \ReflectionProperty(AlibabaCloud::class, 'logger');
        $property->setAccessible(true);
        $property->setValue(null);
    }

    private function assertRedacted($output, array $values)
    {
        foreach ($values as $value) {
            self::assertStringNotContainsString($value, $output);
            self::assertStringNotContainsString(rawurlencode($value), $output);
            self::assertStringNotContainsString(rawurlencode(rawurlencode($value)), $output);
        }
    }
}

class DiagnosticsLogger extends AbstractLogger
{
    public $messages = [];

    public function log($level, $message, array $context = [])
    {
        $this->messages[] = $message;
    }
}
