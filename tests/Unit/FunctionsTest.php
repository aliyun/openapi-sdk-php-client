<?php

namespace AlibabaCloud\Client\Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Class FunctionsTest
 *
 * @package AlibabaCloud\Client\Tests\Unit
 */
class FunctionsTest extends TestCase
{
    public static function testDefault()
    {
        self::assertEquals('default', \AlibabaCloud\Client\env('default', 'default'));
    }

    public static function testEnv()
    {
        self::assertEquals(null, \AlibabaCloud\Client\env('null'));
    }

    public static function testSwitch()
    {
        putenv('TRUE=true');
        self::assertEquals('true', getenv('TRUE'));
        self::assertEquals(true, \AlibabaCloud\Client\env('TRUE'));
        putenv('TRUE=(true)');
        self::assertEquals('(true)', getenv('TRUE'));
        self::assertEquals(true, \AlibabaCloud\Client\env('TRUE'));

        putenv('FALSE=false');
        self::assertEquals('false', getenv('FALSE'));
        self::assertEquals(false, \AlibabaCloud\Client\env('FALSE'));
        putenv('FALSE=(false)');
        self::assertEquals('(false)', getenv('FALSE'));
        self::assertEquals(false, \AlibabaCloud\Client\env('FALSE'));

        putenv('EMPTY=empty');
        self::assertEquals('empty', getenv('EMPTY'));
        self::assertEquals(false, \AlibabaCloud\Client\env('EMPTY'));
        putenv('EMPTY=(empty)');
        self::assertEquals('(empty)', getenv('EMPTY'));
        self::assertEquals('', \AlibabaCloud\Client\env('EMPTY'));

        putenv('NULL=null');
        self::assertEquals('null', getenv('NULL'));
        self::assertEquals(null, \AlibabaCloud\Client\env('NULL'));
        putenv('NULL=(null)');
        self::assertEquals('(null)', getenv('NULL'));
        self::assertEquals(null, \AlibabaCloud\Client\env('NULL'));
    }

    public static function testString()
    {
        putenv('STRING="Alibaba Cloud"');
        self::assertEquals('"Alibaba Cloud"', getenv('STRING'));
        self::assertEquals('Alibaba Cloud', \AlibabaCloud\Client\env('STRING'));

        putenv('STRING="Alibaba Cloud');
        self::assertEquals('"Alibaba Cloud', getenv('STRING'));
        self::assertEquals('"Alibaba Cloud', \AlibabaCloud\Client\env('STRING'));
    }
}
