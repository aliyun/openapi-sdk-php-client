<?php

namespace AlibabaCloud\Client\Tests\Unit\Signature;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

/**
 * Class ShaHmac256WithRsaSignatureTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Signature
 *
 * @coversDefaultClass \AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature
 */
class ShaHmac256WithRsaSignatureTest extends TestCase
{

    /**
     * @covers ::sign
     * @covers ::getMethod
     * @covers ::getVersion
     * @covers ::getType
     * @throws ClientException
     */
    public function testShaHmac256Signature()
    {
        // Setup
        $string         = 'string';
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();
        $expected       =
            'gjWgwRf/BjOYbjrPleU9qzNrZXNO+Z9aiwxmbBj1TPF2/PEOjBy5/YSk+GfL2GGg5pkupzrKiG+4FQ4r+EjeQcdByRDv1x1eBrQHwAbieKmjLc1++vJWQQpSKJykMl5dRzADUwsXYzvCCvVCIXjYZJNsrdt/0G+gaRVX7oelAX+d1MiTjRam7Ugzxcr1nELz2dc3DOyhXqCw8loNtsFVNcrDC5B/urx4eYdAFWRYVbORdTTgPdOF/gNJOWPqQgvFQsICJpScwIXP2OntCjYj8EBGNafBK3bCe4jxHwtxBA72PmuJ/ZHxUqSstwbcVk5S40PlRIhqtrfn6ajxYk41SQ==';

        // Test
        $signature = new ShaHmac256WithRsaSignature();

        // Assert
        static::assertInstanceOf(ShaHmac256WithRsaSignature::class, $signature);
        static::assertEquals('SHA256withRSA', $signature->getMethod());
        static::assertEquals('1.0', $signature->getVersion());
        static::assertEquals('PRIVATEKEY', $signature->getType());
        static::assertEquals(
            $expected,
            $signature->sign($string, \file_get_contents($privateKeyFile))
        );
    }

    public function testShaHmac256SignatureBadPrivateKey()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $reg = '/openssl_sign()/';
        if (method_exists($this, 'expectExceptionMessageMatches')) {
            $this->expectExceptionMessageMatches($reg);
        } elseif (method_exists($this, 'expectExceptionMessageRegExp')) {
            $this->expectExceptionMessageRegExp($reg);
        }
        // Setup
        $string         = 'string';
        $privateKeyFile = VirtualRsaKeyPairCredential::badPrivateKey();

        // Test
        $signature = new ShaHmac256WithRsaSignature();

        // Assert
        $signature->sign($string, \file_get_contents($privateKeyFile));
    }
}
