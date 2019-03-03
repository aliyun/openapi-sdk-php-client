<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class AcsTraitTest
 *
 * @package            AlibabaCloud\Client\Tests\Unit\Request
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\Request
 */
class AcsTraitTest extends TestCase
{
    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     * @expectedExceptionMessage The argument $action cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testActionWithEmpty()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->action('');
    }

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     * @expectedExceptionMessage The argument $version cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testVersionWithEmpty()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->version('');
    }

    /**
     * @throws ClientException
     */
    public function testProduct()
    {
        // Setup
        $product = 'product';
        $request = new RpcRequest();

        // Test
        $request->product($product);

        // Assert
        self::assertEquals($product, $request->product);
    }

    /**
     * @throws ClientException
     * @expectedExceptionMessage The argument $product cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testProductWithEmpty()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->product('');
    }

    /**
     * @throws ClientException
     */
    public function testLocationEndpointType()
    {
        // Setup
        $endpointType = 'endpointType';
        $request      = new RpcRequest();

        // Test
        $request->endpointType($endpointType);

        // Assert
        self::assertEquals(
            $endpointType,
            $request->endpointType
        );
    }

    /**
     * @throws ClientException
     * @expectedExceptionMessage The argument $endpointType cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testLocationEndpointTypeEmpty()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->endpointType('');
    }

    /**
     * @throws ClientException
     */
    public function testLocationServiceCode()
    {
        // Setup
        $serviceCode = 'serviceCode';
        $request     = new RpcRequest();

        // Test
        $request->serviceCode($serviceCode);

        // Assert
        self::assertEquals(
            $serviceCode,
            $request->serviceCode
        );
    }

    /**
     * @throws ClientException
     * @expectedExceptionMessage The argument $serviceCode cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testServiceCodeEmpty()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->serviceCode('');
    }

    /**
     * @throws ClientException
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage The argument $regionId cannot be empty
     * @throws ClientException
     */
    public function testRegionIdEmpty()
    {
        // Setup
        $regionId = '';
        $request  = new RpcRequest();

        // Test
        $request->regionId($regionId);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage The argument $timeout cannot be empty
     * @throws ClientException
     */
    public function testTimeoutEmpty()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->timeout('');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage The argument $connectTimeout cannot be empty
     * @throws ClientException
     */
    public function testConnectTimeout()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->connectTimeout('');
    }

    /**
     * @throws ClientException
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
     * @throws ClientException
     */
    public function testRealRegionIdOnDefault()
    {
        // Setup
        $regionId = 'regionId';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');
        AlibabaCloud::setDefaultRegionId($regionId);

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
     * @expectedExceptionMessage Missing required 'RegionId' for Request
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @throws ClientException
     */
    public function testRealRegionIdException()
    {
        // Setup
        AlibabaCloud::flush();
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');

        // Test
        $request = new RpcRequest();
        $request->client('regionId');
        $request->realRegionId();
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage The argument $regionId cannot be empty
     * @throws                  ClientException
     */
    public function testSetDefaultRegionIdException()
    {
        // Test
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');
        AlibabaCloud::setDefaultRegionId(null);
    }

    /**
     * @throws ClientException
     */
    public function testFindDomainInConfig()
    {
        // Setup
        $regionId = 'cn-shanghai';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name($regionId);
        AlibabaCloud::setDefaultRegionId($regionId);

        // Test
        $request = new RpcRequest();
        $request->client($regionId);
        $request->product('ecs');
        $request->resolveUri();

        // Assert
        self::assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            $request->uri->getHost()
        );
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Can't resolve host for Cdn in us-west-no, You can specify host via the host() method
     * @throws ClientException
     */
    public function testNotFoundHost()
    {
        // Setup
        $regionId = 'us-west-no';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name($regionId);
        AlibabaCloud::setDefaultRegionId($regionId);

        // Test
        $request = new DescribeCdnServiceRequest();
        $request->client($regionId);
        $request->resolveUri();
    }

    /**
     * @throws ClientException
     */
    public function testFindDomainOnLocationService()
    {
        // Setup
        $regionId = 'cn-shanghai';
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name($regionId);
        AlibabaCloud::setDefaultRegionId($regionId);

        // Test
        $request = new RpcRequest();
        $request->client($regionId);
        $request->product('ecs2');
        $request->serviceCode('ecs');

        // Assert
        try {
            $request->resolveUri();
        } catch (ServerException $exception) {
            self::assertEquals('InvalidAccessKeyId.NotFound', $exception->getErrorCode());
        } catch (ClientException $exception) {
            self::assertContains(
                $exception->getErrorCode(),
                [
                    \ALIBABA_CLOUD_SERVER_UNREACHABLE,
                    \ALIBABA_CLOUD_INVALID_REGION_ID,
                ]
            );
        }
    }
}
