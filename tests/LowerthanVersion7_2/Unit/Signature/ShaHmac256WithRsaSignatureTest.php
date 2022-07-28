<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Signature;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

/**
 * Class ShaHmac256WithRsaSignatureTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Signature
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
            'W78DF0crfkZlhKE89dz9V5O03LkzfAZlhGltxdAYzJSL+z0YwgxNgmV15cEkqVONgSDSOqGzceqpBSSnIeoKVHny5TCe7OxBVuWu2nUsqN/PkQQqWDuuBsxqcDiSJ6lchQAqDR/P5BgwiSX2BnRAFQeAiX27lqVPpkYRi2U2ejksSw4e+RfNAPIKBftrpjnVHtFSbwiLsi0kfV/3a1SdXcVf2yUoL3dOs9akp4wQuALWuiBJ+5VNK3a4t4GQm3sfhEC+5tUQeQmdOPlHew8FjR/hXidYEUMHo6t/qNL7kciNy3Zk0iiVLLuhGMsu9tfotSJZKKpeD+4w9VYjv8qptQ==';

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
