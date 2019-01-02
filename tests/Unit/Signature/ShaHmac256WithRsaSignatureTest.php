<?php

namespace AlibabaCloud\Client\Tests\Unit\Signature;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

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
            'hZUg7J/jQYnK8yog47uzzyRvYDsh1m+vpYBsXzjVNSaSE+9q4moiPve/oIfWcWsC0nvjdOpKRhM53YxoafPJJ6Ejga9es4Gclx/4ZRWMdujZbD5EVymd4QyP/d3x2ys6wYmy2jEKT/SDjiEww/A6IXkSdZsJKb0KLDEbN0+G69M=';

        // Test
        $signature = new ShaHmac256WithRsaSignature();

        // Assert
        $this->assertInstanceOf(ShaHmac256WithRsaSignature::class, $signature);
        $this->assertEquals('SHA256withRSA', $signature->getMethod());
        $this->assertEquals('1.0', $signature->getVersion());
        $this->assertEquals('PRIVATEKEY', $signature->getType());
        $this->assertEquals(
            $expected,
            $signature->sign($string, \file_get_contents($privateKeyFile))
        );
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage openssl_sign(): supplied key param cannot be coerced into a private key
     */
    public function testShaHmac256SignatureBadPrivateKey()
    {
        // Setup
        $string         = 'string';
        $privateKeyFile = VirtualRsaKeyPairCredential::badPrivateKey();

        // Test
        $signature = new ShaHmac256WithRsaSignature();

        // Assert
        $signature->sign($string, \file_get_contents($privateKeyFile));
    }
}
