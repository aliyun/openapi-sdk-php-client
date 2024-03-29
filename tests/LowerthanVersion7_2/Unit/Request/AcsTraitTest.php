<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class AcsTraitTest
 *
 * @package            AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Request
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Action cannot be empty
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Action must be a string
     */
    public function testActionWithFormat()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->action(null);
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
     * @expectedExceptionMessage Version cannot be empty
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Version must be a string
     */
    public function testVersionWithFormat()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->version(null);
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

    public function testNetwork()
    {
        // Setup
        $network = 'vpc';
        $request = new RpcRequest();

        // Test
        $request->network($network);

        // Assert
        self::assertEquals($network, $request->network);
    }

    /**
     * @throws ClientException
     * @expectedExceptionMessage Product cannot be empty
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Product must be a string
     */
    public function testProductWithFormat()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->product(null);
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Endpoint Type cannot be empty
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Endpoint Type must be a string
     */
    public function testLocationEndpointTypeFormat()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->endpointType(null);
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Service Code cannot be empty
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Service Code must be a string
     */
    public function testServiceCodeFormat()
    {
        // Setup
        $request = new RpcRequest();

        // Test
        $request->serviceCode(null);
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
            strtolower($regionId),
            $request->realRegionId()
        );
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Region ID cannot be empty
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
     * @expectedExceptionMessage Region ID must be a string
     * @throws ClientException
     */
    public function testRegionIdFormat()
    {
        // Setup
        $regionId = null;
        $request  = new RpcRequest();

        // Test
        $request->regionId($regionId);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Timeout cannot be empty
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
     * @expectedExceptionMessage Connect Timeout cannot be empty
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
            strtolower($regionId),
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
            strtolower($regionId),
            $request->realRegionId()
        );
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testEndpointMap()
    {
        // Setup
        $request = AlibabaCloud::rpc();
        $region  = 'cn-hangzhou';
        $request->regionId($region);
        $request->endpointMap[$region] = 'b.com';

        // Test
        $request->resolveHost();
        self::assertEquals('http://b.com', (string)$request->uri);

        // Setup
        $request = AlibabaCloud::rpc();
        $region  = 'cn-shanghai';
        $request->regionId($region);
        $request->product('ecs');

        // Test
        $request->resolveHost();
        self::assertEquals('http://ecs-cn-hangzhou.aliyuncs.com', (string)$request->uri);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testEndpointRegional()
    {
        // Setup
        $request = AlibabaCloud::rpc();
        $region  = 'cn-hangzhou';
        $request->regionId($region);
        $request->product('ecs');
        $request->endpointRegional = 'regional';

        // Test
        $request->resolveHost();
        self::assertEquals('http://ecs.cn-hangzhou.aliyuncs.com', (string)$request->uri);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testEndpointCentral()
    {
        // Setup
        $request = AlibabaCloud::rpc();
        $region  = 'cn-hangzhou';
        $request->regionId($region);
        $request->product('ecs');
        $request->endpointRegional = 'central';

        // Test
        $request->resolveHost();
        self::assertEquals('http://ecs.aliyuncs.com', (string)$request->uri);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage endpointRegional is invalid.
     */
    public function testEndpointRegionalRnvalid()
    {
        // Setup
        $request = AlibabaCloud::rpc();
        $region  = 'cn-hangzhou';
        $request->regionId($region);
        $request->product('ecs');
        $request->endpointRegional = 'invalid';

        // Test
        $request->resolveHost();
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
     * @expectedExceptionMessage Region ID must be a string
     * @throws                  ClientException
     */
    public function testSetDefaultRegionIdNull()
    {
        // Test
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');
        AlibabaCloud::setDefaultRegionId(null);
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Region ID cannot be empty
     * @throws                  ClientException
     */
    public function testSetDefaultRegionIdEmpty()
    {
        // Test
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');
        AlibabaCloud::setDefaultRegionId('');
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testFindDomainInConfig()
    {
        // Setup
        $request = new RpcRequest();
        $request->product('ecs');
        $request->regionId('eu-central-1');

        // Test
        $request->resolveHost();

        // Assert
        self::assertEquals(
            'ecs.eu-central-1.aliyuncs.com',
            $request->uri->getHost()
        );
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testFindDomainOnLocationService()
    {
        // Setup
        $body = [
            'Endpoints' => [
                'Endpoint' => [
                    0 => [
                        'Endpoint' => 'ecs-cn-hangzhou.aliyuncs.com',
                    ],
                ],
            ],
        ];

        AlibabaCloud::mockResponse(200, [], $body);
        AlibabaCloud::accessKeyClient('foo', 'bar')->asDefaultClient()->regionId('cn-hangzhou');

        // Test
        $request = new RpcRequest();
        $request->product('ecs2');
        $request->serviceCode('ecs');

        // Assert
        $request->resolveHost();
        self::assertEquals('ecs-cn-hangzhou.aliyuncs.com', $request->uri->getHost());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage No host found for no in the cn-hangzhou, you can specify host by host() method. Like
     *                           $request->host('xxx.xxx.aliyuncs.com')
     * @throws ClientException
     * @throws ServerException
     */
    public function testFindDomainOnLocationServiceWithEmpty()
    {
        // Setup
        $body = [
            'Endpoints' => [
                'Endpoint' => [
                    0 => [
                        'Endpoint' => '',
                    ],
                ],
            ],
        ];

        AlibabaCloud::mockResponse(200, [], $body);
        AlibabaCloud::setDefaultRegionId('cn-hangzhou');
        AlibabaCloud::accessKeyClient('ak', 'bar')->asDefaultClient();

        // Test
        $request = new RpcRequest();
        $request->product('no');
        $request->serviceCode('no');

        // Assert
        $request->resolveHost();
        self::assertEquals('ecs-cn-hangzhou.aliyuncs.com', $request->uri->getHost());
    }

    protected function tearDown()
    {
        AlibabaCloud::cancelMock();
    }
}
