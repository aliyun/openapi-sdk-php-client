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

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class AcsTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @coversDefaultClass \AlibabaCloud\Client\Request\Request
 */
class AcsTraitTest extends TestCase
{
    public function testAction()
    {
        // Setup
        $action  = 'action';
        $request = new RpcRequest();

        // Test
        $request->action($action);

        // Assert
        self::assertEquals($action, $request->action);
    }

    public function testVersion()
    {
        // Setup
        $version = 'version';
        $request = new RpcRequest();

        // Test
        $request->version($version);

        // Assert
        self::assertEquals($version, $request->version);
    }

    public function testProduct()
    {
        // Setup
        $product = 'version';
        $request = new RpcRequest();

        // Test
        $request->product($product);

        // Assert
        self::assertEquals($product, $request->product);
    }

    public function testLocationEndpointType()
    {
        // Setup
        $locationEndpointType = 'locationEndpointType';
        $request              = new RpcRequest();

        // Test
        $request->locationEndpointType($locationEndpointType);

        // Assert
        self::assertEquals(
            $locationEndpointType,
            $request->locationEndpointType
        );
    }

    public function testLocationServiceCode()
    {
        // Setup
        $locationServiceCode = 'locationServiceCode';
        $request             = new RpcRequest();

        // Test
        $request->locationServiceCode($locationServiceCode);

        // Assert
        self::assertEquals(
            $locationServiceCode,
            $request->locationServiceCode
        );
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testRealRegionIdOnRequest()
    {
        // Setup
        $regionId = 'regionId';
        $request  = new RpcRequest();

        // Test
        $request->regionId($regionId);

        // Assert
        self::assertEquals(
            $regionId,
            $request->realRegionId()
        );
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testRealRegionIdOnClient()
    {
        // Setup
        $regionId = 'regionId';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->regionId($regionId)
                    ->name('regionId');
        $request = new RpcRequest();

        // Test
        $request->client('regionId');

        // Assert
        self::assertEquals(
            $regionId,
            $request->realRegionId()
        );
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testRealRegionIdOnGlobal()
    {
        // Setup
        $regionId = 'regionId';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');
        AlibabaCloud::setGlobalRegionId($regionId);

        // Test
        $request = new RpcRequest();
        $request->client('regionId');

        // Assert
        self::assertEquals(
            $regionId,
            $request->realRegionId()
        );
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage  Missing required 'RegionId' for Request
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testRealRegionIdException()
    {
        // Setup
        $regionId = 'regionId';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');
        AlibabaCloud::setGlobalRegionId(null);

        // Test
        $request = new RpcRequest();
        $request->client('regionId');

        // Assert
        self::assertEquals(
            $regionId,
            $request->realRegionId()
        );
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testFindDomainInConfig()
    {
        // Setup
        $regionId = 'cn-shanghai';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name($regionId);
        AlibabaCloud::setGlobalRegionId($regionId);

        // Test
        $request = new RpcRequest();
        $request->client($regionId);
        $request->product('ecs');
        $request->resolveHost();

        // Assert
        self::assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            $request->uriComponents->getHost()
        );
    }

    public function testFindDomainOnLocationService()
    {
        // Setup
        $regionId = 'cn-shanghai';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name($regionId);
        AlibabaCloud::setGlobalRegionId($regionId);

        // Test
        $request = new RpcRequest();
        $request->client($regionId);
        $request->product('ecs2');
        $request->locationServiceCode('ecs');

        // Assert
        try {
            $request->resolveHost();
        } catch (ServerException $exception) {
            self::assertEquals('InvalidAccessKeyId.NotFound', $exception->getErrorCode());
        } catch (ClientException $exception) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $exception->getErrorCode());
        }
    }
}
