<?php

namespace AlibabaCloud\Client\Tests\Unit\Signature;

use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ShaHmac256WithRsaSignatureTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Signature
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
     */
    public function testShaHmac256Signature()
    {
        // Setup
        $string         = 'string';
        $publicKeyId    = \getenv('PUBLIC_KEY_ID');
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();
        $expected       =
            'hZUg7J/jQYnK8yog47uzzyRvYDsh1m+vpYBsXzjVNSaSE+9q4moiPve/oIfWcWsC0nvjdOpKRhM53YxoafPJJ6Ejga9es4Gclx/4ZRWMdujZbD5EVymd4QyP/d3x2ys6wYmy2jEKT/SDjiEww/A6IXkSdZsJKb0KLDEbN0+G69M=';

        // Test
        $signature = new ShaHmac256WithRsaSignature($publicKeyId, $privateKeyFile);

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
        $publicKeyId    = \getenv('PUBLIC_KEY_ID');
        $privateKeyFile = VirtualRsaKeyPairCredential::badPrivateKey();

        // Test
        $signature = new ShaHmac256WithRsaSignature();

        // Assert
        $signature->sign($string, \file_get_contents($privateKeyFile));
    }
}
