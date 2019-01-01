<?php

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
 * @package   AlibabaCloud\Client\Tests\Unit\Endpoint
 *
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
