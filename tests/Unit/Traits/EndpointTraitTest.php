<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Traits
 */
class EndpointTraitTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function testFindProductDomain()
    {
        static::assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            AlibabaCloud::resolveHost('Ecs', 'cn-hangzhou')
        );
        static::assertEquals(
            'kms.me-east-1.aliyuncs.com',
            AlibabaCloud::resolveHost('kms', 'me-east-1')
        );
    }

    /**
     * Test for AddEndpoint
     *
     * @throws ClientException
     */
    public function testAddHost()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $product  = 'TestProduct';
        $host     = 'testproduct.aliyuncs.com';

        // Test
        AlibabaCloud::addHost($product, $host, $regionId);

        // Assert
        self::assertEquals($host, AlibabaCloud::resolveHost($product, $regionId));
    }

    /**
     * @throws ClientException
     */
    public function testResolveHostByStatic()
    {
        $host = 'host.com';
        AlibabaCloud::addHost('product', $host, 'cn-hangzhou');
        $expected = AlibabaCloud::resolveHostByStatic('product', 'cn-hangzhou');
        self::assertEquals($host, $expected);
    }

    /**
     * Test for AddEndpoint
     *
     * @throws ClientException
     */
    public function testAddHostWithProductEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Product cannot be empty");
        AlibabaCloud::addHost('', 'host', 'regionId');
    }

    /**
     * Test for AddEndpoint
     *
     * @throws ClientException
     */
    public function testAddHostWithProductFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Product must be a string");
        AlibabaCloud::addHost(null, 'host', 'regionId');
    }

    /**
     * Test for AddEndpoint
     *
     * @throws ClientException
     */
    public function testAddHostWithHostEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Host cannot be empty");
        AlibabaCloud::addHost('product', '', 'regionId');
    }

    /**
     * Test for AddEndpoint
     *
     * @throws ClientException
     */
    public function testAddHostWithHostFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Host must be a string");
        AlibabaCloud::addHost('product', null, 'regionId');
    }

    /**
     * Test for AddEndpoint
     *
     * @throws ClientException
     */
    public function testAddHostWithRegionIdFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Region ID must be a string");
        AlibabaCloud::addHost('product', 'host', null);
    }

    /**
     * Test for AddEndpoint
     *
     * @throws ClientException
     */
    public function testAddHostWithRegionIdEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Region ID cannot be empty");
        AlibabaCloud::addHost('product', 'host', '');
    }

    /**
     * @throws ClientException
     */
    public function testLocationServiceResolveHostWithException()
    {
        $this->expectException(ServerException::class);
        $reg = '/Please check the parameters RequestId:/';
        if (method_exists($this, 'expectExceptionMessageMatches')) {
            $this->expectExceptionMessageMatches($reg);
        } elseif (method_exists($this, 'expectExceptionMessageRegExp')) {
            $this->expectExceptionMessageRegExp($reg);
        }
        // Setup
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::mockResponse(
            400,
            [],
            [
                'Message' => 'Please check the parameters',
            ]
        );
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId('cn-hangzhou')
                    ->asDefaultClient();

        // Test
        $request = new RpcRequest();
        $request->connectTimeout(25)->timeout(30);
        $request->product     = 'Dysmsapi';
        $request->serviceCode = 'dysmsapi';

        // Assert
        LocationService::resolveHost($request);
    }

    /**
     * @throws ClientException
     */
    public function testAddGlobalHost()
    {
        // Setup
        $product = 'a';
        $host    = 'a.com';

        // Test
        AlibabaCloud::addHost($product, $host);

        // Assert
        self::assertEquals($host, AlibabaCloud::resolveHost($product));
    }

    /**
     * @throws ClientException
     */
    public function testGlobal()
    {
        // Assert
        self::assertEquals('', AlibabaCloud::resolveHost('dysmsapi'));
        self::assertEquals('dysmsapi.aliyuncs.com', AlibabaCloud::resolveHost('dysmsapi', 'cn-hangzhou'));
    }


    public function testIsGlobalProduct()
    {
        self::assertTrue(AlibabaCloud::isGlobalProduct('ccc'));
        self::assertFalse(AlibabaCloud::isGlobalProduct('no'));
        self::assertTrue(AlibabaCloud::isGlobalProduct('Ram'));
        self::assertTrue(AlibabaCloud::isGlobalProduct('ram'));
        self::assertFalse(AlibabaCloud::isGlobalProduct('tdsr'));
        self::assertFalse(AlibabaCloud::isGlobalProduct(''));
        self::assertFalse(AlibabaCloud::isGlobalProduct(null));
    }

    /**
     * Test for Null
     *
     * @throws ClientException
     */
    public function testNull()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $product  = 'null';

        // Test
        self::assertEquals('', AlibabaCloud::resolveHost($product, $regionId));
    }
}
