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
            EndpointProvider::resolveHost('cn-hangzhou', 'Ecs')
        );
        $this->assertEquals(
            'kms.me-east-1.aliyuncs.com',
            EndpointProvider::resolveHost('me-east-1', 'kms')
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
            AlibabaCloud::resolveHost('cn-hangzhou', 'Ecs')
        );
        $this->assertEquals(
            'kms.me-east-1.aliyuncs.com',
            AlibabaCloud::resolveHost('me-east-1', 'kms')
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
        $domain   = 'testproduct.aliyuncs.com';

        // Test
        EndpointProvider::addEndpoint($regionId, $product, $domain);

        // Assert
        self::assertEquals($domain, EndpointProvider::findProductDomain($regionId, $product));

        // Test
        AlibabaCloud::addHost($regionId, $product, $domain);

        // Assert
        self::assertEquals($domain, AlibabaCloud::findProductDomain($regionId, $product));

        // Test
        AlibabaCloud::addHost($regionId, $product, $domain);

        // Assert
        self::assertEquals($domain, AlibabaCloud::resolveHost($regionId, $product));
    }

    /**
     * Test for Null
     */
    public function testNull()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $product  = 'TestProduct2';

        // Test
        self::assertEquals('', AlibabaCloud::findProductDomain($regionId, $product));
        self::assertEquals('', AlibabaCloud::resolveHost($regionId, $product));
    }
}
