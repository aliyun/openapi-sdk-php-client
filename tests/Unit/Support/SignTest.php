<?php

namespace AlibabaCloud\Client\Tests\Unit\Support;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Support\Sign;

class SignTest extends TestCase
{
    public function testUUID()
    {
        self::assertEquals(36, strlen(Sign::uuid()));
    }
}
