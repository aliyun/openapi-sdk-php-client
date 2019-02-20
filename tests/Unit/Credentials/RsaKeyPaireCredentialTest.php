<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Exception\ClientException;
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

    public static function testNotFoundFile()
    {
        // Setup
        $publicKeyId = \getenv('PUBLIC_KEY_ID');
        if (\AlibabaCloud\Client\isWindows()) {
            $privateKeyFile = 'C:\\projects\\no.no';
        } else {
            $privateKeyFile = '/a/b/no.no';
        }

        // Test
        try {
            new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
        } catch (ClientException $e) {
            self::assertEquals(
                "file_get_contents($privateKeyFile): failed to open stream: No such file or directory",
                $e->getErrorMessage()
            );
        }
    }

    public static function testOpenBasedirException()
    {
        // Setup
        $publicKeyId = \getenv('PUBLIC_KEY_ID');
        if (\AlibabaCloud\Client\isWindows()) {
            $dirs           = 'C:\\projects;C:\\Users';
            $privateKeyFile = 'C:\\AlibabaCloud\\no.no';
        } else {
            $dirs           = 'vfs://AlibabaCloud:/home:/Users:/private:/a/b';
            $privateKeyFile = '/dev/no.no';
        }

        // Test
        ini_set('open_basedir', $dirs);
        try {
            new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
        } catch (ClientException $e) {
            self::assertEquals(
                "file_get_contents(): open_basedir restriction in effect. File($privateKeyFile) is not within the allowed path(s): ($dirs)",
                $e->getErrorMessage()
            );
        }
    }
}
