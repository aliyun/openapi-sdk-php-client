<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClusterServicesRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Nlp\NlpRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RequestTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asGlobalClient()
                    ->regionId('cn-hangzhou');
    }

    public function testConstruct()
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $request->setClusterId($clusterId);

        // Test
        try {
            $request->request();
            // Assert
        } catch (ServerException $e) {
            // Assert
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'InvalidAccessKeyId.NotFound',
                    ]
                );
            } else {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'ErrorClusterNotFound',
                    ]
                );
            }
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    public function testWithBearerTokenCredential()
    {
        // Setup
        $regionId    = 'cn-hangzhou';
        $bearerToken = 'BEARER_TOKEN';
        AlibabaCloud::bearerTokenClient($bearerToken)
                    ->name('BEARER_TOKEN')
                    ->regionId($regionId);

        // Test
        try {
            (new  DescribeClusterServicesRequest())->client('BEARER_TOKEN')
                                                   ->setClusterId(\time())
                                                   ->request();
        } catch (ServerException $e) {
            // Assert
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    public function testInvalidUrl()
    {
        // Setup
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name(__METHOD__);

        // Test
        try {
            (new  DescribeClusterServicesRequest())->client(__METHOD__)
                                                   ->setClusterId(\time())
                                                   ->request();
        } catch (ServerException $e) {
            // Assert
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                $this->assertEquals(
                    $e->getErrorCode(),
                    'InvalidAccessKeyId.NotFound'
                );
            } else {
                $this->assertEquals(
                    $e->getErrorCode(),
                    'ErrorClusterNotFound'
                );
            }
        } catch (ClientException $e) {
            // Assert
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     */
    public function testROA()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        $request->setClusterId(\time());

        // Test
        try {
            $request->request();
            // Assert
        } catch (ServerException $e) {
            // Assert
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                $this->assertEquals(
                    $e->getErrorCode(),
                    'InvalidAccessKeyId.NotFound'
                );
            } else {
                $this->assertEquals(
                    $e->getErrorCode(),
                    'ErrorClusterNotFound'
                );
            }
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    public function testRoaContent()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('NLP_ACCESS_KEY_ID'),
            \getenv('NLP_ACCESS_KEY_SECRET')
        )->name('content')
                    ->regionId('cn-shanghai');

        $request = new NlpRequest();
        $request->debug(true);
        $request->body('{"lang":"ZH","text":"Iphone专用数据线"}');

        try {
            $result = $request->client('content')->request();
            self::assertEquals('Iphone', $result['data'][0]['word']);
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                $this->assertEquals(
                    $e->getErrorCode(),
                    'InvalidAccessKeyId.NotFound'
                );
            } else {
                $this->assertEquals(
                    $e->getErrorCode(),
                    'InvalidApi.NotPurchase'
                );
            }
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error', $e->getErrorMessage());
        }
    }
}
