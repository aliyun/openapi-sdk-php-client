<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use PHPUnit\Framework\TestCase;

/**
 * Class RegionTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
