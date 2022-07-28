<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Support;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Support\Arrays;

class ArraysTest extends TestCase
{
    public function testMerge()
    {
        $array1 = [1 => 'abc'];
        $array2 = ['a', 'b'];
        $params = Arrays::merge(
            [
                $array1,
                $array2
            ]
        );

        self::assertEquals(
            [
                0 => 'abc',
                1 => 'a',
                2 => 'b'
            ],
            $params
        );
    }
}
