<?php

namespace AlibabaCloud\Client\Tests\Unit\Regions;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\SDK;
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
     * @throws ServerException
     */
    public function testAddEndPoint()
    {
        // Setup
        $regionId = 'a';
        $product  = 'b';
        $domain   = 'c';

        // Test
        $request = AlibabaCloud::rpc()->regionId($regionId)->product($product);
        LocationService::addEndPoint($regionId, $product, $domain);

        // Assert
        self::assertEquals(LocationService::findProductDomain($request), $domain);
    }

    /**
     * @throws ClientException
     * @throws ServerException
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
     * @throws ClientException
     * @throws ServerException
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /Not found Region ID in location.aliyuncs.com/
     */
    public function testResolveHostWithServiceUnknownError()
    {
        AlibabaCloud::mockResponse();
        $request = AlibabaCloud::rpc()->product(__METHOD__)
                               ->regionId('regionId');

        $host = LocationService::resolveHost($request);
        self::assertEquals('', $host);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Not found Region ID in location.aliyuncs.com
     * @throws ClientException
     * @throws ServerException
     */
    public function testResolveHostNotFound()
    {
        AlibabaCloud::mockResponse();

        $request = AlibabaCloud::rpc()->product(__METHOD__)->regionId('regionId');

        LocationService::resolveHost($request);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testResolveHostSuccess()
    {
        $body = [
            'Endpoints' => [
                'Endpoint' => [
                    0 => [
                        'Endpoint' => 'cdn.aliyun.com',
                    ],
                ],
            ],
        ];

        AlibabaCloud::mockResponse(200, [], $body);

        $request = AlibabaCloud::rpc()->product(__METHOD__)->regionId('regionId');

        $host = LocationService::resolveHost($request);

        self::assertEquals('cdn.aliyun.com', $host);
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
     * @expectedException \AlibabaCloud\Client\Exception\ServerException
     * @expectedExceptionMessageRegExp /InvalidAccessKeyId.NotFound: Specified access key is not found/
     * @throws ClientException
     * @throws ServerException
     */
    public function testLocationServiceException()
    {
        AlibabaCloud::accessKeyClient('key', 'secret')->asDefaultClient();
        $request = (new DeleteDatabaseRequest())
            ->regionId('cn-hangzhou')
            ->connectTimeout(25)
            ->timeout(30);
        try {
            LocationService::findProductDomain($request);
        } catch (ClientException $e) {
            self::assertEquals(SDK::SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     * @throws ServerException
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

    protected function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::cancelMock();
    }
}
