<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\Rds\DeleteDatabaseRequest;

/**
 * Class RequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\Request
 */
class RequestTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public static function testIsset()
    {
        // Setup
        $request = new DeleteDatabaseRequest();

        // Get
        self::assertFalse(isset($request->object));

        // Set
        $request->object = 'object';

        // Isset
        self::assertTrue(isset($request->object));
        self::assertEquals('object', $request->object);

        // Unset
        unset($request->object);
        self::assertEquals(null, $request->object);
    }

    /**
     * @throws ClientException
     */
    public static function testRequest()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertArrayNotHasKey('verify', $request->options);

        // Test
        $request->verify(true);

        // Assert
        self::assertTrue($request->options['verify']);
    }

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $options = ['testConstruct' => __METHOD__];
        putenv('DEBUG=sdk');

        // Test
        $rpcRequest = new RpcRequest($options);
        $roaRequest = new RoaRequest($options);

        // Assert
        self::assertEquals(__METHOD__, $rpcRequest->options['testConstruct']);
        self::assertEquals(__METHOD__, $roaRequest->options['testConstruct']);
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithNameEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Name cannot be empty");
        $request = new RpcRequest();
        $request->appendUserAgent('', 'value');
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithNameFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Name must be a string");
        $request = new RpcRequest();
        $request->appendUserAgent(null, 'value');
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithValueEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Value cannot be empty");
        $request = new RpcRequest();
        $request->appendUserAgent('name', '');
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithValueFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Value must be a string");
        $request = new RpcRequest();
        $request->appendUserAgent('name', null);
    }

    /**
     * @throws ClientException
     */
    public function testFormat()
    {
        // Setup
        $format     = 'rss';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->format($format);
        $roaRequest->format($format);

        // Assert
        self::assertEquals(\strtoupper($format), $rpcRequest->format);
        self::assertEquals(\strtoupper($format), $roaRequest->format);
    }

    /**
     * @throws ClientException
     */
    public function testFormatWithEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Format cannot be empty");
        $request = new RpcRequest();
        $request->format('');
    }

    /**
     * @throws ClientException
     */
    public function testFormatWithNull()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Format must be a string");
        $request = new RpcRequest();
        $request->format(null);
    }

    /**
     * @throws ClientException
     */
    public function testBody()
    {
        // Setup
        $body       = 'rss';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->body($body);
        $roaRequest->body($body);

        // Assert
        self::assertEquals($body, $rpcRequest->options['body']);
        self::assertEquals($body, $roaRequest->options['body']);
    }

    /**
     * @throws ClientException
     */
    public function testBodyEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Body cannot be empty");
        $request = new RpcRequest();
        $request->body('');
    }

    /**
     * @throws ClientException
     */
    public function testBodyNotString()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Body must be a string");
        $request = new RpcRequest();
        $request->body(null);
    }

    /**
     * @throws ClientException
     */
    public function testJsonBody()
    {
        // Setup
        $body       = ['test' => 'test'];
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->jsonBody($body);
        $roaRequest->jsonBody($body);

        // Assert
        self::assertEquals('{"test":"test"}', $rpcRequest->options['body']);
        self::assertEquals('{"test":"test"}', $roaRequest->options['body']);
    }

    /**
     * @throws                  ClientException
     */
    public function testJsonBodyFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("jsonBody only accepts an array or object");
        $request = new RpcRequest();

        $request->jsonBody(null);
    }

    /**
     * @throws ClientException
     */
    public function testScheme()
    {
        // Setup
        $scheme     = 'no';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->scheme($scheme);
        $roaRequest->scheme($scheme);

        // Assert
        self::assertEquals($scheme, $rpcRequest->uri->getScheme());

        self::assertEquals($scheme, $roaRequest->uri->getScheme());
    }

    /**
     * @throws ClientException
     */
    public function testSchemeFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Scheme must be a string");
        $request = new RpcRequest();
        $request->scheme(null);
    }

    /**
     * @throws ClientException
     */
    public function testSchemeEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Scheme cannot be empty");
        $request = new RpcRequest();
        $request->scheme('');
    }

    /**
     * @throws ClientException
     */
    public function testHost()
    {
        // Setup
        $host       = 'domain';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->host($host);
        $roaRequest->host($host);

        // Assert
        self::assertEquals($host, $rpcRequest->uri->getHost());
        self::assertEquals($host, $roaRequest->uri->getHost());
    }

    /**
     * @throws ClientException
     */
    public function testHostFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Host must be a string");
        $request = new RpcRequest();
        $request->host(null);
    }

    /**
     * @throws ClientException
     */
    public function testHostEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Host cannot be empty");
        $request = new RpcRequest();
        $request->host('');
    }

    /**
     * @throws ClientException
     */
    public function testMethod()
    {
        // Setup
        $method     = 'method';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->method($method);
        $roaRequest->method($method);

        // Assert
        self::assertEquals(\strtoupper($method), $rpcRequest->method);
        self::assertEquals(\strtoupper($method), $roaRequest->method);
    }

    /**
     * @throws ClientException
     */
    public function testMethodEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Method cannot be empty");
        $request = new RpcRequest();
        $request->method('');
    }

    /**
     * @throws ClientException
     */
    public function testMethodFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Method must be a string");
        $request = new RpcRequest();
        $request->method(null);
    }

    /**
     * @throws ClientException
     */
    public function testClient()
    {
        // Setup
        $clientName = 'clientName';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->client($clientName);
        $roaRequest->client($clientName);

        // Assert
        self::assertEquals(strtolower($clientName), $rpcRequest->client);
        self::assertEquals(strtolower($clientName), $roaRequest->client);
    }

    /**
     * @throws ClientException
     */
    public function testClientEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name cannot be empty");
        $request = new RpcRequest();
        $request->client('');
    }

    /**
     * @throws ClientException
     */
    public function testClientFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name must be a string");
        $request = new RpcRequest();
        $request->client(null);
    }

    /**
     * @throws ClientException
     */
    public function testIsDebug()
    {
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->name('temp');
        $request = (new DeleteDatabaseRequest())->client('temp')
                                                ->debug(false);
        self::assertFalse($request->isDebug());

        unset($request->options['debug']);
        AlibabaCloud::get('temp')->debug(false);
        self::assertFalse($request->isDebug());

        unset($request->options['debug'], AlibabaCloud::get('temp')->options['debug']);
        self::assertFalse($request->isDebug());
    }

    /**
     * @throws ClientException
     */
    public function testRequestWithServiceException()
    {
        // Setup
        $request = new DeleteDatabaseRequest();
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->regionId('cn-hangzhou')
                    ->connectTimeout(15)
                    ->timeout(10)
                    ->name('temp');

        try {
            $request->client('temp')
                    ->request();
        } catch (ServerException $e) {
            self::assertEquals('Specified access key is not found.', $e->getErrorMessage());
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error', $e->getErrorMessage());
        }
    }

    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function testRequestWithClientException()
    {
        // Setup
        $request = new DeleteDatabaseRequest();
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->regionId('cn-hangzhou')
                    ->name('temp');

        try {
            $request->client('temp')
                    ->timeout(0.01)
                    ->request();
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error', $e->getErrorMessage());
        }
    }
}
