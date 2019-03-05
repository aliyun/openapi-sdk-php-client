<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
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
    /**
     * @throws ClientException
     */
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
