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
                                                ->connectTimeout(25)
                                                ->timeout(30)
                                                ->request();

        $this->assertNotNull($result->RequestId);
        $this->assertNotNull($result->Regions->Region[0]->LocalName);
        $this->assertNotNull($result->Regions->Region[0]->RegionId);
    }

    /**
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
            $result = $request->connectTimeout(25)
                              ->timeout(30)
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

    /**
     * @throws ClientException
     */
    public function testCall()
    {
        $request = new RpcRequest();

        $request->setPrefix('set');
        self::assertEquals('set', $request->getPrefix());
        self::assertEquals(['Prefix' => 'set',], $request->options['query']);

        $request->withPrefix('with');
        self::assertEquals('with', $request->getPrefix());
        self::assertEquals(['Prefix' => 'with',], $request->options['query']);

        $request->setprefix('set');
        self::assertEquals('set', $request->getprefix());
        self::assertEquals(['Prefix' => 'with', 'prefix' => 'set',], $request->options['query']);

        $request->withprefix('with');
        self::assertEquals('with', $request->getprefix());
        self::assertEquals(['Prefix' => 'with', 'prefix' => 'with',], $request->options['query']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Call to undefined method AlibabaCloud\Client\Request\RpcRequest::nowithvalue()
     * @throws ClientException
     */
    public function testCallException()
    {
        $request = new RpcRequest();
        $request->nowithvalue('value');
    }
}
