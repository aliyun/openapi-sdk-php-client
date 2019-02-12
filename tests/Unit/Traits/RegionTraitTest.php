<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use PHPUnit\Framework\TestCase;

/**
 * Class RegionTraitTest.
 *
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\RegionTrait
 */
class RegionTraitTest extends TestCase
{
    /**
     * @covers ::getGlobalRegionId
     * @covers ::setGlobalRegionId
     */
    public function testGlobalRegionId()
    {
        // Setup
        $regionId = 'test';
        $this->assertNull(AlibabaCloud::getGlobalRegionId());

        // Test
        AlibabaCloud::setGlobalRegionId($regionId);

        // Assert
        $this->assertEquals($regionId, AlibabaCloud::getGlobalRegionId());
    }
}
