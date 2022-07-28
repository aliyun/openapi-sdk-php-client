<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * Class AcsTraitTest
 *
 * @package            AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Request
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
     */
    public function testActionWithEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Action cannot be empty");
        // Setup
        $request = new RpcRequest();

        // Test
        $request->action('');
    }

    /**
     * @throws ClientException
     */
    public function testActionWithFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Action must be a string");
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
     */
    public function testVersionWithEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Version cannot be empty");
        // Setup
        $request = new RpcRequest();

        // Test
        $request->version('');
    }

    /**
     * @throws ClientException
     */
    public function testVersionWithFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Version must be a string");
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
     */
    public function testProductWithEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Product cannot be empty");
        // Setup
        $request = new RpcRequest();

        // Test
        $request->product('');
    }

    /**
     * @throws ClientException
     */
    public function testProductWithFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Product must be a string");
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
     */
    public function testLocationEndpointTypeEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Endpoint Type cannot be empty");
        // Setup
        $request = new RpcRequest();

        // Test
        $request->endpointType('');
    }

    /**
     * @throws ClientException
     */
    public function testLocationEndpointTypeFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Endpoint Type must be a string");
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
     */
    public function testServiceCodeEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Service Code cannot be empty");
        // Setup
        $request = new RpcRequest();

        // Test
        $request->serviceCode('');
    }

    /**
     * @throws ClientException
     */
    public function testServiceCodeFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Service Code must be a string");
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
     * @throws ClientException
     */
    public function testRegionIdEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Region ID cannot be empty");
        // Setup
        $regionId = '';
        $request  = new RpcRequest();

        // Test
        $request->regionId($regionId);
    }

    /**
     * @throws ClientException
     */
    public function testRegionIdFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Region ID must be a string");
        // Setup
        $regionId = null;
        $request  = new RpcRequest();

        // Test
        $request->regionId($regionId);
    }

    /**
     * @throws ClientException
     */
    public function testTimeoutEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Timeout cannot be empty");
        // Setup
        $request = new RpcRequest();

        // Test
        $request->timeout('');
    }

    /**
     * @throws ClientException
     */
    public function testConnectTimeout()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Connect Timeout cannot be empty");
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
     */
    public function testEndpointRegionalRnvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("endpointRegional is invalid.");
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
     * @throws ClientException
     */
    public function testRealRegionIdException()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Missing required 'RegionId' for Request");
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
     * @throws                  ClientException
     */
    public function testSetDefaultRegionIdNull()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Region ID must be a string");
        // Test
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->name('regionId');
        AlibabaCloud::setDefaultRegionId(null);
    }

    /**
     * @throws                  ClientException
     */
    public function testSetDefaultRegionIdEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Region ID cannot be empty");
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
     * @throws ClientException
     * @throws ServerException
     */
    public function testFindDomainOnLocationServiceWithEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("No host found for no in the cn-hangzhou, you can specify host by host() method. Like \$request->host('xxx.xxx.aliyuncs.com')");
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

    protected function tearDown(): void
    {
        AlibabaCloud::cancelMock();
    }
}
