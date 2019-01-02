<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class RsaKeyPaireCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\RsaKeyPairCredential
 */
class RsaKeyPaireCredentialTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::getPublicKeyId
     * @covers ::getPrivateKey
     * @covers ::__toString
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testConstruct()
    {
        // Setup
        $publicKeyId    = \getenv('PUBLIC_KEY_ID');
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();

        // Test
        $credential = new RsaKeyPairCredential($publicKeyId, $privateKeyFile);

        // Assert
        $this->assertEquals($publicKeyId, $credential->getPublicKeyId());
        $this->assertStringEqualsFile($privateKeyFile, $credential->getPrivateKey());
        $this->assertEquals(
            "publicKeyId#$publicKeyId",
            (string)$credential
        );
    }

    /**
     * @covers                   ::__construct
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage file_get_contents(/no/no.no): failed to open stream: No such file or directory
     */
    public function testException()
    {
        // Setup
        $publicKeyId    = \getenv('PUBLIC_KEY_ID');
        $privateKeyFile = '/no/no.no';

        // Test
        new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
    }
}
