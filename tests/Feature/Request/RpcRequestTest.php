<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RpcRequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class RpcRequestTest extends TestCase
{
    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function testWithCredential()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = \getenv('REGION_ID');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Assert

        $result = (new DescribeRegionsRequest())->client($nameClient)
                                                ->connectTimeout(15)
                                                ->timeout(20)
                                                ->request();

        $this->assertNotNull($result->RequestId);
        $this->assertNotNull($result->Regions->Region[0]->LocalName);
        $this->assertNotNull($result->Regions->Region[0]->RegionId);
    }

    /**
     * @covers ::booleanValueToString
     * @covers ::resolveParameters
     * @covers \AlibabaCloud\Client\Request\Request::setQueryParameters
     * @throws ClientException
     */
    public function testWithBearerTokenCredential()
    {
        // Setup
        $regionId    = \getenv('REGION_ID');
        $bearerToken = 'BEARER_TOKEN';

        // Test
        AlibabaCloud::bearerTokenClient($bearerToken)
                    ->regionId($regionId)
                    ->name($bearerToken);

        // Assert
        try {
            $request = new DescribeRegionsRequest();
            $request->options(
                [
                    'query' => [
                        'test_true'  => 1,
                        'test_false' => 1,
                    ],
                ]
            );
            $this->assertEquals(1, $request->options['query']['test_true']);
            $this->assertEquals(1, $request->options['query']['test_false']);
            $result = $request->connectTimeout(15)
                              ->timeout(20)
                              ->request();
            self::assertArrayHasKey('Regions', $result);
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }

    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function testRpc()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asGlobalClient()->regionId('cn-hangzhou');

        $result = (new RpcRequest())->method('POST')
                                    ->product('Cdn')
                                    ->version('2014-11-11')
                                    ->action('DescribeCdnService')
                                    ->connectTimeout(15)
                                    ->timeout(20)
                                    ->request();

        self::assertNotEmpty('PayByTraffic', $result['ChangingChargeType']);
    }
}
