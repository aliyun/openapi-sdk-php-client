<?php

namespace AlibabaCloud\Client\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;

/**
 * Class AlibabaCloudTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class AlibabaCloudTest extends TestCase
{
    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Please install alibabacloud/sdk to support product quick access.
     */
    public static function testCallStatic()
    {
        AlibabaCloud::Ecs();
    }

    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::flush();
    }
}
