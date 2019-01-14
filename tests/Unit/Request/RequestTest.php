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
    public function testConstruct()
    {
        // Setup
        $options = ['testConstruct' => __METHOD__];

        // Test
        $rpcRequest = new RpcRequest($options);
        $roaRequest = new RoaRequest($options);

        // Assert
        self::assertEquals(__METHOD__, $rpcRequest->options['testConstruct']);
        self::assertEquals(__METHOD__, $roaRequest->options['testConstruct']);
    }

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
     * @throws \AlibabaCloud\Client\Exception\ClientException
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
     * @throws \AlibabaCloud\Client\Exception\ServerException
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

    public function testIsset()
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
}
