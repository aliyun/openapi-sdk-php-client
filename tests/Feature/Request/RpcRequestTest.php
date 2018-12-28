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
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class RpcRequestTest extends TestCase
{
    public function testWithCredential()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Assert

        try {
            $response = (new DescribeRegionsRequest())->client($nameClient)
                                                      ->request();

            $this->assertNotNull($response->RequestId);
            $this->assertNotNull($response->Regions->Region[0]->LocalName);
            $this->assertNotNull($response->Regions->Region[0]->RegionId);
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Specified access key is not found.',
                ]
            );
        }
    }

    /**
     * @covers ::booleanValueToString
     * @covers ::resolveParameters
     * @covers \AlibabaCloud\Client\Request\Request::setQueryParameters
     */
    public function testWithBearerTokenCredential()
    {
        // Setup
        $regionId    = 'cn-hangzhou';
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
            $request->request();
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertContains(
                $e->getErrorCode(),
                [
                    'UnsupportedSignatureType',
                    'InvalidAccessKeyId.NotFound',
                ]
            );
        }
    }

    public function testRpc()
    {
        try {
            if (!AlibabaCloud::has(\ALIBABA_CLOUD_GLOBAL_CLIENT)) {
                AlibabaCloud::accessKeyClient('key', 'secret')
                            ->asGlobalClient()
                            ->regionId('cn-hangzhou');
            }

            $result = (new RpcRequest())->method('POST')
                                        ->timeout(0.1)
                                        ->product('Cdn')
                                        ->version('2014-11-11')
                                        ->action('DescribeCdnService')
                                        ->request();

            \assertNotEmpty($result->toArray());
        } catch (ClientException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                ]
            );
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'You do not have access to this operation.',
                    'Specified access key is not found.',
                ]
            );
        }
    }
}
