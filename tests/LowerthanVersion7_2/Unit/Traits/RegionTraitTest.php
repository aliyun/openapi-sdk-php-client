<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Traits;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class RegionTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Client\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\DefaultRegionTrait
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
        static::assertNull(AlibabaCloud::getDefaultRegionId());

        // Test
        AlibabaCloud::setDefaultRegionId($regionId);

        // Assert
        static::assertEquals($regionId, AlibabaCloud::getDefaultRegionId());
    }
}
