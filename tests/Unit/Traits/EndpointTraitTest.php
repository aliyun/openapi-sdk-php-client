<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Regions\EndpointProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Traits
 */
class EndpointTraitTest extends TestCase
{
    public function testFindProductDomain()
    {
        $this->assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            EndpointProvider::findProductDomain('cn-hangzhou', 'Ecs')
        );
        $this->assertEquals(
            'kms.me-east-1.aliyuncs.com',
            EndpointProvider::findProductDomain('me-east-1', 'kms')
        );
        $this->assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            EndpointProvider::resolveHost('Ecs', 'cn-hangzhou')
        );
        $this->assertEquals(
            'kms.me-east-1.aliyuncs.com',
            EndpointProvider::resolveHost('kms', 'me-east-1')
        );
        $this->assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            AlibabaCloud::findProductDomain('cn-hangzhou', 'Ecs')
        );
        $this->assertEquals(
            'kms.me-east-1.aliyuncs.com',
            AlibabaCloud::findProductDomain('me-east-1', 'kms')
        );
        $this->assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            AlibabaCloud::resolveHost('Ecs', 'cn-hangzhou')
        );
        $this->assertEquals(
            'kms.me-east-1.aliyuncs.com',
            AlibabaCloud::resolveHost('kms', 'me-east-1')
        );
    }

    /**
     * Test for AddEndpoint
     */
    public function testAddEndpoint()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $product  = 'TestProduct';
        $host     = 'testproduct.aliyuncs.com';

        // Test
        EndpointProvider::addEndpoint($regionId, $product, $host);

        // Assert
        self::assertEquals($host, EndpointProvider::findProductDomain($regionId, $product));

        // Test
        AlibabaCloud::addHost($product, $host, $regionId);

        // Assert
        self::assertEquals($host, AlibabaCloud::findProductDomain($regionId, $product));

        // Test
        AlibabaCloud::addHost($product, $host, $regionId);

        // Assert
        self::assertEquals($host, AlibabaCloud::resolveHost($product, $regionId));
    }

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

    public function testGlobal()
    {
        // Assert
        self::assertEquals('dysmsapi.aliyuncs.com', AlibabaCloud::resolveHost('dysmsapi'));
        self::assertEquals('dysmsapi.aliyuncs.com', AlibabaCloud::resolveHost('dysmsapi', 'cn-hangzhou'));
    }

    /**
     * Test for Null
     */
    public function testNull()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $product  = 'null';

        // Test
        self::assertEquals('', AlibabaCloud::findProductDomain($regionId, $product));
        self::assertEquals('', AlibabaCloud::resolveHost($product, $regionId));
    }
}
