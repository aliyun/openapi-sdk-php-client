<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Feature\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;

/**
 * Class ProxyTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Feature\Request
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class ProxyTest extends TestCase
{
    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function testNoProxy()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Test
        $result = (new DescribeRegionsRequest())->client($nameClient)
                                                ->connectTimeout(25)
                                                ->timeout(30)
                                                ->request();

        // Assert
        $headers = $result->getHeaders();
        static::assertArrayNotHasKey('Via', $headers);
    }

    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function testProxyWithoutPassword()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Test
        $result = (new DescribeRegionsRequest())->client($nameClient)
                                                ->connectTimeout(25)
                                                ->timeout(30)
                                                ->proxy([
                                                            'http' => 'http://localhost:8989',
                                                        ])
                                                ->request();

        // Assert
        $headers = $result->getHeaders();
        static::assertArrayHasKey('Via', $headers);
        static::assertEquals('HTTP/1.1 o_o', $headers['Via'][0]);
        static::assertNotNull($result->RequestId);
        static::assertNotNull($result->Regions->Region[0]->LocalName);
        static::assertNotNull($result->Regions->Region[0]->RegionId);
    }

    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function testProxyWithPassword()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Test
        $result = (new DescribeRegionsRequest())->client($nameClient)
                                                ->connectTimeout(25)
                                                ->timeout(30)
                                                ->proxy([
                                                            'http' => 'http://username:password@localhost:8989',
                                                        ])
                                                ->request();

        // Assert
        $headers = $result->getHeaders();
        static::assertArrayHasKey('Via', $headers);
        static::assertEquals('HTTP/1.1 o_o', $headers['Via'][0]);
        static::assertNotNull($result->RequestId);
        static::assertNotNull($result->Regions->Region[0]->LocalName);
        static::assertNotNull($result->Regions->Region[0]->RegionId);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /cURL error/
     * @throws ClientException
     * @throws ServerException
     */
    public function testProxyNotSet()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Assert
        (new DescribeRegionsRequest())->client($nameClient)
                                      ->connectTimeout(1)
                                      ->timeout(2)
                                      ->proxy([
                                                  'http' => 'http://localhost:55657',
                                              ])
                                      ->request();
    }
}
