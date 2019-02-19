<?php

namespace AlibabaCloud\Client\Tests\Unit;

use AlibabaCloud\Client\AlibabaCloud;
use PHPUnit\Framework\TestCase;

/**
 * Class AlibabaCloudTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class AlibabaCloudTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::flush();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Please install alibabacloud/sdk to support product quick access.
     */
    public function testCallStatic()
    {
        AlibabaCloud::Ecs();
    }
}
