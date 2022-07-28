<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Support;

use AlibabaCloud\Client\Support\Sign;
use PHPUnit\Framework\TestCase;

class SignTest extends TestCase
{
    public function testUUID()
    {
        self::assertEquals(53, strlen(Sign::uuid('uuid')));
    }
}
