<?php

namespace AlibabaCloud\Client\Tests\Unit\Signature;

use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use PHPUnit\Framework\TestCase;

/**
 * Class ShaHmac1SignatureTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Signature
 *
 * @coversDefaultClass \AlibabaCloud\Client\Signature\ShaHmac1Signature
 */
class ShaHmac1SignatureTest extends TestCase
{

    /**
     * @covers ::sign
     * @covers ::getMethod
     * @covers ::getVersion
     * @covers ::getType
     */
    public function testShaHmac1Signature()
    {
        // Setup
        $string          = 'this is a ShaHmac1 test.';
        $accessKeySecret = 'accessKeySecret';
        $expected        = 'PEr0Vp78B4Fslzf54dzdXD4Qt3E=';

        // Test
        $signature = new ShaHmac1Signature();

        // Assert
        $this->assertInstanceOf(ShaHmac1Signature::class, $signature);
        $this->assertEquals('HMAC-SHA1', $signature->getMethod());
        $this->assertEquals('1.0', $signature->getVersion());
        $this->assertEquals('', $signature->getType());
        $this->assertEquals($expected, $signature->sign($string, $accessKeySecret));
    }
}
