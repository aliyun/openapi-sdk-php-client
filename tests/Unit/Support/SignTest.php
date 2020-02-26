<?php

namespace AlibabaCloud\Client\Tests\Unit\Support;

use AlibabaCloud\Client\Support\Sign;
use PHPUnit\Framework\TestCase;

class SignTest extends TestCase
{
    public function testUUID()
    {
        self::assertEquals(53, strlen(Sign::uuid('uuid')));
    }
}
