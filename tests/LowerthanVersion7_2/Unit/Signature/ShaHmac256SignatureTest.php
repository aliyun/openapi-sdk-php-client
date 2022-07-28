<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Signature;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Signature\ShaHmac256Signature;

/**
 * Class ShaHmac256SignatureTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Signature
 *
 * @coversDefaultClass \AlibabaCloud\Client\Signature\ShaHmac256Signature
 */
class ShaHmac256SignatureTest extends TestCase
{

    /**
     * @covers ::sign
     * @covers ::getMethod
     * @covers ::getVersion
     * @covers ::getType
     */
    public function testShaHmac256Signature()
    {
        // Setup
        $string          = 'this is a ShaHmac256 test.';
        $accessKeySecret = 'accessKeySecret';
        $expected        = 'v1Kg2HYGWRaLsRu2iXkAZu3R7vDh0txyYHs48HVxkeA=';

        // Test
        $signature = new ShaHmac256Signature();

        // Assert
        static::assertInstanceOf(ShaHmac256Signature::class, $signature);
        static::assertEquals('HMAC-SHA256', $signature->getMethod());
        static::assertEquals('1.0', $signature->getVersion());
        static::assertEquals('', $signature->getType());
        static::assertEquals(
            $expected,
            $signature->sign($string, $accessKeySecret)
        );
    }
}
