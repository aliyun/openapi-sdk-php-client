<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit\Client\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\DefaultAcsClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Profile\DefaultProfile;
use AlibabaCloud\Client\Regions\EndpointProvider;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClusterServicesRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Nlp\NlpRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RoaRequestTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Client\Request
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\RoaRequest
 */
class RoaRequestTest extends TestCase
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

    /**
     * @covers ::__construct
     */
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
                    ->name(\time());

        // Test
        try {
            (new  DescribeClusterServicesRequest())->client(\time())->request();
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
                    'InvalidUrl'
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

    public function testPathParameters()
    {
        $request = new  DescribeClusterServicesRequest();
        $request->pathParameter('time', 'time');
        self::assertEquals('time', $request->pathParameters['time']);
    }

    public function testRoaContent()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->name('content')
                    ->regionId('cn-shanghai');

        $request = new NlpRequest();
        $request->body('{"lang":"ZH","text":"Iphone专用数据线"}');
        try {
            $result = $request->client('content')->request();
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
