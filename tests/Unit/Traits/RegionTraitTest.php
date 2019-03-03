<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use PHPUnit\Framework\TestCase;

/**
 * Class RegionTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\RegionTrait
 */
class RegionTraitTest extends TestCase
{
    public function testDefaultRegionId()
    {
        // Setup
        $regionId = 'test';
        $this->assertNull(AlibabaCloud::getDefaultRegionId());

        // Test
        AlibabaCloud::setDefaultRegionId($regionId);

        // Assert
        $this->assertEquals($regionId, AlibabaCloud::getDefaultRegionId());
    }
}
