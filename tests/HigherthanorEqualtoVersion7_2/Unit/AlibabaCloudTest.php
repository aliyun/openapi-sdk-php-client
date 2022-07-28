<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class AlibabaCloudTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class AlibabaCloudTest extends TestCase
{

    public function testCallStatic()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessageMatches('/May not yet support product/');
        AlibabaCloud::Ecs();
    }

    public function tearDown(): void
    {
        AlibabaCloud::flush();
    }
}
