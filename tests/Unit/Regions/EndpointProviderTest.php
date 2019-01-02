<?php

namespace AlibabaCloud\Client\Tests\Unit\Regions;

use AlibabaCloud\Client\Regions\EndpointProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Regions
 */
class EndpointProviderTest extends TestCase
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
        self::assertEquals('', EndpointProvider::findProductDomain($regionId, $product));
    }
}
