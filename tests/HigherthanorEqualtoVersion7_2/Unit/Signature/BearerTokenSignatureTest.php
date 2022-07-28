<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Signature;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Signature\BearerTokenSignature;

/**
 * Class BearerTokenSignatureTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Signature
 *
 * @coversDefaultClass \AlibabaCloud\Client\Signature\BearerTokenSignature
 */
class BearerTokenSignatureTest extends TestCase
{

    /**
     * @covers ::sign
     * @covers ::getMethod
     * @covers ::getVersion
     * @covers ::getType
     */
    public function testBearerTokenSignature()
    {
        // Setup
        $string          = 'this is a BearToken test.';
        $accessKeySecret = 'accessKeySecret';
        $expected        = null;

        // Test
        $signature = new BearerTokenSignature();

        // Assert
        static::assertInstanceOf(BearerTokenSignature::class, $signature);
        static::assertEquals($expected, $signature->sign($string, $accessKeySecret));
        static::assertEquals('', $signature->getMethod());
        static::assertEquals('1.0', $signature->getVersion());
        static::assertEquals('BEARERTOKEN', $signature->getType());
    }
}
