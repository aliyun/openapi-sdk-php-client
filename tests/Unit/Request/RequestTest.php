<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Rds\DeleteDatabaseRequest;
use PHPUnit\Framework\TestCase;

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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Name cannot be empty
     * @throws ClientException
     */
    public function testAppendUserAgentWithNameEmpty()
    {
        $request = new RpcRequest();
        $request->appendUserAgent('', 'value');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Name must be a string
     * @throws ClientException
     */
    public function testAppendUserAgentWithNameFormat()
    {
        $request = new RpcRequest();
        $request->appendUserAgent(null, 'value');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Value cannot be empty
     * @throws ClientException
     */
    public function testAppendUserAgentWithValueEmpty()
    {
        $request = new RpcRequest();
        $request->appendUserAgent('name', '');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Value must be a string
     * @throws ClientException
     */
    public function testAppendUserAgentWithValueFormat()
    {
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Format cannot be empty
     * @throws ClientException
     */
    public function testFormatWithEmpty()
    {
        $request = new RpcRequest();
        $request->format('');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Format must be a string
     * @throws ClientException
     */
    public function testFormatWithNull()
    {
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Body cannot be empty
     * @throws ClientException
     */
    public function testBodyEmpty()
    {
        $request = new RpcRequest();
        $request->body('');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Body must be a string
     * @throws ClientException
     */
    public function testBodyNotString()
    {
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
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage jsonBody only accepts an array or object
     * @throws                  ClientException
     */
    public function testJsonBodyFormat()
    {
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
        self::assertEquals($scheme, $rpcRequest->scheme);
        self::assertEquals($scheme, $rpcRequest->uri->getScheme());

        self::assertEquals($scheme, $roaRequest->scheme);
        self::assertEquals($scheme, $roaRequest->uri->getScheme());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Scheme must be a string
     * @throws ClientException
     */
    public function testSchemeFormat()
    {
        $request = new RpcRequest();
        $request->scheme(null);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Scheme cannot be empty
     * @throws ClientException
     */
    public function testSchemeEmpty()
    {
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Host must be a string
     * @throws ClientException
     */
    public function testHostFormat()
    {
        $request = new RpcRequest();
        $request->host(null);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Host cannot be empty
     * @throws ClientException
     */
    public function testHostEmpty()
    {
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Method cannot be empty
     * @throws ClientException
     */
    public function testMethodEmpty()
    {
        $request = new RpcRequest();
        $request->method('');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Method must be a string
     * @throws ClientException
     */
    public function testMethodFormat()
    {
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
        self::assertEquals($clientName, $rpcRequest->client);
        self::assertEquals($clientName, $roaRequest->client);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client Name cannot be empty
     * @throws ClientException
     */
    public function testClientEmpty()
    {
        $request = new RpcRequest();
        $request->client('');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client Name must be a string
     * @throws ClientException
     */
    public function testClientFormat()
    {
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
