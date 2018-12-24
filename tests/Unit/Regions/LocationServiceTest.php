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

namespace AlibabaCloud\Client\Tests\Unit\Regions;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Rds\DeleteDatabaseRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class LocationServiceTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Regions
 *
 * @category     AlibabaCloud
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 */
class LocationServiceTest extends TestCase
{
    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testAddEndPoint()
    {
        // Setup
        $regionId = 'a';
        $product  = 'b';
        $domain   = 'c';

        // Test
        $request = (new RpcRequest())->regionId($regionId)->product($product);
        LocationService::addEndPoint($regionId, $product, $domain);

        // Assert
        self::assertEquals(LocationService::findProductDomain($request), $domain);
    }

    public function testLocationServiceWithBadAK()
    {
        AlibabaCloud::accessKeyClient('key', 'secret')->asGlobalClient();
        $request = (new DeleteDatabaseRequest())->regionId('cn-hangzhou');
        try {
            LocationService::findProductDomain($request);
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertEquals('Specified access key is not found.', $e->getErrorMessage());
        }
    }

    public function testLocationServiceWithBadServiceDomain()
    {
        AlibabaCloud::accessKeyClient('key', 'secret')->asGlobalClient();
        $request = (new DeleteDatabaseRequest())->regionId('cn-hangzhou');
        try {
            LocationService::findProductDomain($request, 'not.alibaba.com');
        } catch (ClientException $e) {
            self::assertEquals(
                'cURL error 6: Could not resolve host: not.alibaba.com (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)',
                $e->getErrorMessage()
            );
        } catch (ServerException $e) {
            self::assertEquals('Specified access key is not found.', $e->getErrorMessage());
        }
    }
}
