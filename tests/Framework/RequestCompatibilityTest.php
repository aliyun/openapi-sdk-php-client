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
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Framework;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\DefaultAcsClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Profile\DefaultProfile;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Test the compatibility of the new SDK with the old SDK.
 *
 * @package   AlibabaCloud\Client\Tests\Framework
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RequestCompatibilityTest extends TestCase
{
    public function testGetAcsResponse()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $key      = \getenv('ACCESS_KEY_ID');
        $secret   = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::accessKeyClient($key, $secret)->name('test');

        // Test
        $profile = DefaultProfile::getProfile($regionId, $key, $secret);

        $client  = new DefaultAcsClient($profile);
        $request = new DescribeRegionsRequest();
        try {
            $result = $client->getAcsResponse($request->client('test'));
            // Assert
            self::assertNotEquals($result->getRequest()->clientName, 'test');
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                $this->assertEquals(
                    $e->getErrorMessage(),
                    'Specified access key is not found.'
                );
            }
        }
    }

    public function testGetAcsResponseWithResult()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $key      = \getenv('ACCESS_KEY_ID');
        $secret   = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::accessKeyClient($key, $secret)->regionId($regionId)
                    ->name('test');

        // Test
        $profile = DefaultProfile::getProfile($regionId, $key, $secret);
        $client  = new DefaultAcsClient($profile);
        $request = new DescribeRegionsRequest();
        try {
            $result = $client->getAcsResponse($request->client('test')->request());
            // Assert
            self::assertEquals($result->getRequest()->clientName, 'test');
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                $this->assertEquals(
                    $e->getErrorMessage(),
                    'Specified access key is not found.'
                );
            } else {
                $this->assertEquals(
                    $e->getErrorMessage(),
                    'InvalidApi.NotPurchase'
                );
            }
        }
    }

    /**
     * Clear sharing settings.
     */
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::flush();
    }
}
