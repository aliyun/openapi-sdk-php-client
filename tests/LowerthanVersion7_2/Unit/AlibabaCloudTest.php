<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;

/**
 * Class AlibabaCloudTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class AlibabaCloudTest extends TestCase
{
    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /May not yet support product/
     */
    public static function testCallStatic()
    {
        AlibabaCloud::Ecs();
    }

    public function tearDown()
    {
        AlibabaCloud::flush();
    }
}
