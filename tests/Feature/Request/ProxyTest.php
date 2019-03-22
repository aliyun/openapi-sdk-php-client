<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class ProxyTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
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
        $headers = $result->getResponse()->getHeaders();
        $this->assertArrayNotHasKey('Via', $headers);
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
        $headers = $result->getResponse()->getHeaders();
        $this->assertArrayHasKey('Via', $headers);
        $this->assertEquals('HTTP/1.1 o_o', $headers['Via'][0]);
        $this->assertNotNull($result->RequestId);
        $this->assertNotNull($result->Regions->Region[0]->LocalName);
        $this->assertNotNull($result->Regions->Region[0]->RegionId);
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
        $headers = $result->getResponse()->getHeaders();
        $this->assertArrayHasKey('Via', $headers);
        $this->assertEquals('HTTP/1.1 o_o', $headers['Via'][0]);
        $this->assertNotNull($result->RequestId);
        $this->assertNotNull($result->Regions->Region[0]->LocalName);
        $this->assertNotNull($result->Regions->Region[0]->RegionId);
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
