<?php

namespace AlibabaCloud\Client\Tests\Unit\Regions;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Rds\DeleteDatabaseRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class LocationServiceTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Endpoint
 */
class LocationServiceTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function testAddEndPoint()
    {
        // Setup
        $regionId = 'a';
        $product  = 'b';
        $domain   = 'c';

        // Test
        $request = (new RpcRequest())->regionId($regionId)->product($product);
        LocationService::addEndPoint($regionId, $product, $domain);

        // Assert
        self::assertEquals(LocationService::findProductDomain($request), $domain);
    }

    /**
     * @throws ClientException
     */
    public function testAddHost()
    {
        // Setup
        $product  = 'b';
        $host     = 'c';
        $regionId = 'a';

        // Test
        $request = AlibabaCloud::rpc()->regionId($regionId)->product($product);
        LocationService::addHost($product, $host, $regionId);

        // Assert
        self::assertEquals(LocationService::resolveHost($request), $host);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Product cannot be empty
     * @throws ClientException
     */
    public function testAddHostWithProductEmpty()
    {
        LocationService::addHost('', 'host', 'regionId');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Product must be a string
     * @throws ClientException
     */
    public function testAddHostWithProductFormat()
    {
        LocationService::addHost(null, 'host', 'regionId');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Host cannot be empty
     * @throws ClientException
     */
    public function testAddHostWithHostEmpty()
    {
        LocationService::addHost('product', '', 'regionId');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Host must be a string
     * @throws ClientException
     */
    public function testAddHostWithHostFormat()
    {
        LocationService::addHost('product', null, 'regionId');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Region ID cannot be empty
     * @throws ClientException
     */
    public function testAddHostWithRegionIdEmpty()
    {
        LocationService::addHost('product', 'host', '');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Region ID must be a string
     * @throws ClientException
     */
    public function testAddHostWithRegionIdFormat()
    {
        LocationService::addHost('product', 'host', null);
    }

    /**
     * @throws ClientException
     */
    public function testLocationServiceWithBadAK()
    {
        AlibabaCloud::accessKeyClient('key', 'secret')->asDefaultClient();
        $request = (new DeleteDatabaseRequest())->regionId('cn-hangzhou');
        try {
            LocationService::findProductDomain($request);
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testLocationServiceWithBadServiceDomain()
    {
        AlibabaCloud::accessKeyClient('key', 'secret')->asDefaultClient();
        $request = (new DeleteDatabaseRequest())->regionId('cn-hangzhou');
        try {
            LocationService::findProductDomain($request, 'not.alibaba.com');
        } catch (ClientException $e) {
            self::assertEquals(
                'cURL error 6: Could not resolve host: not.alibaba.com (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)',
                $e->getErrorMessage()
            );
        }
    }
}
