<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;

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
        $nameClient = 'name';
        $regionId = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
        $accessKeyId = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
            ->regionId($regionId)
            ->name($nameClient);

        // Assert

        $result = (new DescribeRegionsRequest())->client($nameClient)
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        static::assertNotNull($result->RequestId);
        static::assertNotNull($result->Regions->Region[0]->LocalName);
        static::assertNotNull($result->Regions->Region[0]->RegionId);
    }

    /**
     * @covers \AlibabaCloud\Client\Request\Request::setQueryParameters
     * @throws ClientException
     */
    public function testWithBearerTokenCredential()
    {
        // Setup
        $regionId = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
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
                        'test_true' => 1,
                        'test_false' => 1,
                    ],
                ]
            );
            static::assertEquals(1, $request->options['query']['test_true']);
            static::assertEquals(1, $request->options['query']['test_false']);
            $result = $request->connectTimeout(25)
                ->timeout(30)
                ->request();
            self::assertArrayHasKey('Regions', $result);
        } catch (ServerException $e) {
            static::assertEquals('UnsupportedSignatureType', $e->getErrorCode());
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
        )->asDefaultClient()->regionId('cn-hangzhou');

        $result = (new RpcRequest())->method('POST')
            ->product('Cdn')
            ->version('2014-11-11')
            ->action('DescribeCdnService')
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        self::assertNotEmpty('PayByTraffic', $result['ChangingChargeType']);
    }
}
