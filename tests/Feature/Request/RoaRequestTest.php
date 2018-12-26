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

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RoaRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RoaRequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RoaRequestTest extends TestCase
{
    public function testRoa()
    {
        // Setup
        $clusterId = \time();

        // Test
        try {
            if (!AlibabaCloud::has(\ALIBABA_CLOUD_GLOBAL_CLIENT)) {
                AlibabaCloud::accessKeyClient('key', 'secret')
                            ->asGlobalClient()
                            ->regionId('cn-hangzhou');
            }

            $result = (new RoaRequest())->pathPattern('/clusters/[ClusterId]/services')
                                        ->method('GET')
                                        ->product('CS')
                                        ->version('2015-12-15')
                                        ->action('DescribeClusterServices')
                                        ->setClusterId($clusterId)
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
                    "cluster ($clusterId) not found in our records",
                    'Specified access key is not found.',
                ]
            );
        }
    }
}
