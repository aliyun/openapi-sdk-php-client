<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class SignatureV2Test extends TestCase
{
    public static function rpcCases()
    {
        return [
            ['GET', false, false], ['POST', false, false],
            ['GET', true, false], ['POST', true, false],
            ['GET', false, true], ['POST', false, true],
            ['GET', true, true], ['POST', true, true]
        ];
    }

    /** @dataProvider rpcCases */
    public function testRpcFinalRequest($method, $sts, $sha1)
    {
        $this->reset();
        $credential = $sts
            ? new StsCredential('test-key', 'test-secret', 'token+/=')
            : new AccessKeyCredential('test-key', 'test-secret');
        if ($sha1) {
            AlibabaCloud::client($credential, new ShaHmac1Signature())->name('signing');
        } elseif ($sts) {
            AlibabaCloud::stsClient('test-key', 'test-secret', 'token+/=')->name('signing');
        } else {
            AlibabaCloud::accessKeyClient('test-key', 'test-secret')->name('signing');
        }
        AlibabaCloud::mockResponse(200, [], '{}');
        $this->rpc($method)->withValue('Unicode-中文 +/~*')->request();
        $message = AlibabaCloud::getHistory()[0]['request'];
        $parameters = $this->parameters($message);
        self::assertSame('HMAC-SHA' . ($sha1 ? '1' : '256'), $parameters['SignatureMethod']);
        self::assertSame('1.0', $parameters['SignatureVersion']);
        self::assertSame('Unicode-中文 +/~*', $parameters['Value']);
        self::assertSame($sts ? 'token+/=' : null, isset($parameters['SecurityToken']) ? $parameters['SecurityToken'] : null);
        $this->assertRpcSignature($message, 'test-secret', $sha1 ? 'sha1' : 'sha256');
        AlibabaCloud::cancelMock();
    }

    public static function roaCases()
    {
        return [['GET', false], ['POST', false], ['GET', true], ['POST', true]];
    }

    /** @dataProvider roaCases */
    public function testRoaFinalRequest($method, $sha1)
    {
        $this->reset();
        if ($sha1) {
            AlibabaCloud::client(new StsCredential('test-key', 'test-secret', 'token+/='), new ShaHmac1Signature())
                ->name('signing');
        } else {
            AlibabaCloud::stsClient('test-key', 'test-secret', 'token+/=')->name('signing');
        }
        AlibabaCloud::mockResponse(200, [], '{}');
        $request = AlibabaCloud::roa()->client('signing')->host('example.test')->regionId('cn-hangzhou')
            ->version('2020-01-01')->pathPattern('/test')->method($method);
        if ($method === 'POST') {
            $request->options(['form_params' => ['Value' => '中文 +/~*']]);
        }
        $request->request();
        $message = AlibabaCloud::getHistory()[0]['request'];
        self::assertSame('HMAC-SHA' . ($sha1 ? '1' : '256'), $message->getHeaderLine('x-acs-signature-method'));
        self::assertSame('1.0', $message->getHeaderLine('x-acs-signature-version'));
        self::assertSame('token+/=', $message->getHeaderLine('x-acs-security-token'));
        if ($method === 'POST') {
            self::assertSame(base64_encode(md5((string)$message->getBody(), true)), $message->getHeaderLine('Content-MD5'));
        }
        $canonical = $method . "\n" . $message->getHeaderLine('Accept') . "\n"
            . $message->getHeaderLine('Content-MD5') . "\n" . $message->getHeaderLine('Content-Type') . "\n"
            . $message->getHeaderLine('Date') . "\n";
        $headers = [];
        foreach ($message->getHeaders() as $name => $values) {
            if (strpos(strtolower($name), 'x-acs-') === 0) {
                $headers[strtolower($name)] = $values[0];
            }
        }
        ksort($headers);
        foreach ($headers as $name => $value) {
            $canonical .= $name . ':' . $value . "\n";
        }
        $canonical .= '/test?' . rawurldecode($message->getUri()->getQuery());
        self::assertSame(
            'acs test-key:' . base64_encode(hash_hmac($sha1 ? 'sha1' : 'sha256', $canonical, 'test-secret', true)),
            $message->getHeaderLine('Authorization')
        );
        AlibabaCloud::cancelMock();
    }

    public static function algorithms()
    {
        return [[false], [true]];
    }

    /** @dataProvider algorithms */
    public function testAssumeRoleUsesSelectedAlgorithm($sha1)
    {
        $this->reset();
        $sourceSecret = uniqid('source-secret-' . ($sha1 ? 'sha1' : 'sha256') . '-', true);
        if ($sha1) {
            AlibabaCloud::client(
                new RamRoleArnCredential('source-key', $sourceSecret, 'acs:ram::123:role/test', 'session'),
                new ShaHmac1Signature()
            )->name('signing');
        } else {
            AlibabaCloud::ramRoleArnClient('source-key', $sourceSecret, 'acs:ram::123:role/test', 'session')
                ->name('signing');
        }
        AlibabaCloud::mockResponse(200, [], ['Credentials' => [
            'AccessKeyId' => 'temporary-key', 'AccessKeySecret' => 'temporary-secret',
            'SecurityToken' => 'temporary-token', 'Expiration' => gmdate('c', time() + 7200)
        ]]);
        AlibabaCloud::mockResponse(200, [], '{}');
        $this->rpc('GET')->request();
        $history = AlibabaCloud::getHistory();
        self::assertCount(2, $history);
        foreach ($history as $transaction) {
            $parameters = $this->parameters($transaction['request']);
            self::assertSame('HMAC-SHA' . ($sha1 ? '1' : '256'), $parameters['SignatureMethod']);
        }
        self::assertSame('AssumeRole', $this->parameters($history[0]['request'])['Action']);
        $this->assertRpcSignature($history[0]['request'], $sourceSecret, $sha1 ? 'sha1' : 'sha256');
        $this->assertRpcSignature($history[1]['request'], 'temporary-secret', $sha1 ? 'sha1' : 'sha256');
        self::assertSame('temporary-token', $this->parameters($history[1]['request'])['SecurityToken']);
        AlibabaCloud::cancelMock();
    }

    public function testAsyncAndRetrySignatures()
    {
        $this->reset();
        AlibabaCloud::accessKeyClient('test-key', 'test-secret')->name('signing');
        AlibabaCloud::mockResponse(200, [], '{}');
        $this->rpc('GET')->requestAsync()->wait();
        $this->assertRpcSignature(AlibabaCloud::getHistory()[0]['request'], 'test-secret', 'sha256');
        AlibabaCloud::cancelMock();
        AlibabaCloud::forgetHistory();
        AlibabaCloud::mockResponse(503, [], '{}');
        AlibabaCloud::mockResponse(200, [], '{}');
        $this->rpc('POST')->retryByServer(1, [], [503])->request();
        self::assertCount(2, AlibabaCloud::getHistory());
        foreach (AlibabaCloud::getHistory() as $transaction) {
            $this->assertRpcSignature($transaction['request'], 'test-secret', 'sha256');
        }
        AlibabaCloud::cancelMock();
    }

    public function testEcsRoleUsesSha256AfterMetadataExchange()
    {
        $this->reset();
        AlibabaCloud::ecsRamRoleClient(uniqid('signature-v2-test-role-', true))->name('signing');
        AlibabaCloud::mockResponse(200, [], [
            'AccessKeyId' => 'temporary-key', 'AccessKeySecret' => 'temporary-secret',
            'SecurityToken' => 'temporary-token', 'Expiration' => gmdate('c', time() + 7200)
        ]);
        AlibabaCloud::mockResponse(200, [], '{}');
        $this->rpc('GET')->request();
        $history = AlibabaCloud::getHistory();
        self::assertCount(2, $history);
        self::assertNotFalse(strpos((string)$history[0]['request']->getUri(), '/latest/meta-data/ram/security-credentials/'));
        self::assertSame('HMAC-SHA256', $this->parameters($history[1]['request'])['SignatureMethod']);
        $this->assertRpcSignature($history[1]['request'], 'temporary-secret', 'sha256');
        AlibabaCloud::cancelMock();
    }

    public function testRsaExchangeKeepsRsaAndSignsBusinessRequestWithSha256()
    {
        $this->reset();
        $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        self::assertNotFalse($key);
        openssl_pkey_export($key, $pem);
        $file = tempnam(__DIR__, 'signature-rsa-');
        file_put_contents($file, $pem);
        try {
            AlibabaCloud::rsaKeyPairClient(uniqid('signature-v2-rsa-key-', true), $file)->name('signing');
        } finally {
            unlink($file);
        }
        AlibabaCloud::mockResponse(200, [], ['SessionAccessKey' => [
            'SessionAccessKeyId' => 'temporary-key', 'SessionAccessKeySecret' => 'temporary-secret',
            'Expiration' => gmdate('c', time() + 7200)
        ]]);
        AlibabaCloud::mockResponse(200, [], '{}');
        $this->rpc('GET')->request();
        $history = AlibabaCloud::getHistory();
        self::assertCount(2, $history);
        $exchange = $this->parameters($history[0]['request']);
        self::assertSame('SHA256withRSA', $exchange['SignatureMethod']);
        self::assertSame('PRIVATEKEY', $exchange['SignatureType']);
        $signature = base64_decode($exchange['Signature']);
        unset($exchange['Signature']);
        $details = openssl_pkey_get_details($key);
        self::assertSame(1, openssl_verify($this->canonicalRpcString($history[0]['request']->getMethod(), $exchange), $signature, $details['key'], OPENSSL_ALGO_SHA256));
        self::assertSame('HMAC-SHA256', $this->parameters($history[1]['request'])['SignatureMethod']);
        $this->assertRpcSignature($history[1]['request'], 'temporary-secret', 'sha256');
        AlibabaCloud::cancelMock();
    }

    public function testBearerAuthenticationIsUnchanged()
    {
        $this->reset();
        AlibabaCloud::bearerTokenClient('test-bearer-token')->name('signing');
        AlibabaCloud::mockResponse(200, [], '{}');
        $this->rpc('GET')->request();
        $parameters = $this->parameters(AlibabaCloud::getHistory()[0]['request']);
        self::assertSame('BEARERTOKEN', $parameters['SignatureType']);
        self::assertSame('', $parameters['SignatureMethod']);
        self::assertSame('', $parameters['Signature']);
        self::assertSame('test-bearer-token', $parameters['BearerToken']);
        AlibabaCloud::cancelMock();
    }

    private function reset()
    {
        AlibabaCloud::flush();
        AlibabaCloud::cancelMock();
        AlibabaCloud::forgetHistory();
        AlibabaCloud::rememberHistory();
    }

    private function rpc($method)
    {
        return AlibabaCloud::rpc()->client('signing')->host('example.test')->regionId('cn-hangzhou')
            ->version('2020-01-01')->action('DescribeRegions')->method($method);
    }

    private function parameters(Request $request)
    {
        parse_str($request->getMethod() === 'POST' ? (string)$request->getBody() : $request->getUri()->getQuery(), $parameters);
        return $parameters;
    }

    private function assertRpcSignature(Request $request, $secret, $algorithm)
    {
        $parameters = $this->parameters($request);
        $signature = $parameters['Signature'];
        unset($parameters['Signature']);
        $canonical = $this->canonicalRpcString($request->getMethod(), $parameters);
        self::assertSame(base64_encode(hash_hmac($algorithm, $canonical, $secret . '&', true)), $signature);
    }

    private function canonicalRpcString($method, array $parameters)
    {
        ksort($parameters);
        $parts = [];
        foreach ($parameters as $name => $value) {
            if ($value !== '') {
                $parts[] = rawurlencode($name) . '=' . rawurlencode($value);
            }
        }
        return $method . '&%2F&' . rawurlencode(implode('&', $parts));
    }
}
