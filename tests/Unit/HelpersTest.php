<?php

namespace AlibabaCloud\Client\Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Class HelpersTest
 *
 * @package AlibabaCloud\Client\Tests\Unit
 */
class HelpersTest extends TestCase
{
    public static function testDefault()
    {
        self::assertEquals('default', env('default', 'default'));
    }

    public static function testEnv()
    {
        self::assertEquals(null, env('null'));
    }

    public static function testSwitch()
    {
        putenv('TRUE=true');
        self::assertEquals('true', getenv('TRUE'));
        self::assertEquals(true, env('TRUE'));
        putenv('TRUE=(true)');
        self::assertEquals('(true)', getenv('TRUE'));
        self::assertEquals(true, env('TRUE'));

        putenv('FALSE=false');
        self::assertEquals('false', getenv('FALSE'));
        self::assertEquals(false, env('FALSE'));
        putenv('FALSE=(false)');
        self::assertEquals('(false)', getenv('FALSE'));
        self::assertEquals(false, env('FALSE'));

        putenv('EMPTY=empty');
        self::assertEquals('empty', getenv('EMPTY'));
        self::assertEquals(false, env('EMPTY'));
        putenv('EMPTY=(empty)');
        self::assertEquals('(empty)', getenv('EMPTY'));
        self::assertEquals('', env('EMPTY'));

        putenv('NULL=null');
        self::assertEquals('null', getenv('NULL'));
        self::assertEquals(null, env('NULL'));
        putenv('NULL=(null)');
        self::assertEquals('(null)', getenv('NULL'));
        self::assertEquals(null, env('NULL'));
    }

    public static function testString()
    {
        putenv('STRING="Alibaba Cloud"');
        self::assertEquals('"Alibaba Cloud"', getenv('STRING'));
        self::assertEquals('Alibaba Cloud', env('STRING'));

        putenv('STRING="Alibaba Cloud');
        self::assertEquals('"Alibaba Cloud', getenv('STRING'));
        self::assertEquals('"Alibaba Cloud', env('STRING'));
    }
}
