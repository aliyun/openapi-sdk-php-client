<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

/**
 * Class RsaKeyPairCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\RsaKeyPairCredential
 */
class RsaKeyPairCredentialTest extends TestCase
{
    public static function testNotFoundFile()
    {
        // Setup
        $publicKeyId = 'PUBLIC_KEY_ID';
        if (\AlibabaCloud\Client\isWindows()) {
            $privateKeyFile = 'c:\\projects\\no.no';
        } else {
            $privateKeyFile = '/a/b/no.no';
        }

        // Test
        try {
            new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
        } catch (ClientException $e) {
            self::assertEquals(
                "file_get_contents($privateKeyFile): failed to open stream: no such file or directory",
                strtolower($e->getErrorMessage())
            );
        }
    }

    public static function testOpenBasedirException()
    {
        // Setup
        $publicKeyId = 'PUBLIC_KEY_ID';
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

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $publicKeyId    = 'public_key_id';
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
     * @throws ClientException
     */
    public function testPublicKeyIdEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Public Key ID cannot be empty');
        // Setup
        $publicKeyId    = '';
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();

        // Test
        new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
    }

    /**
     * @throws ClientException
     */
    public function testPublicKeyIdFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Public Key ID must be a string');
        // Setup
        $publicKeyId    = null;
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();

        // Test
        new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
    }

    /**
     * @throws ClientException
     */
    public function testPrivateKeyFileEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Private Key File cannot be empty');
        // Setup
        $publicKeyId    = 'publicKeyId';
        $privateKeyFile = '';

        // Test
        new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
    }

    /**
     * @throws ClientException
     */
    public function testPrivateKeyFileFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Private Key File must be a string');
        // Setup
        $publicKeyId    = 'publicKeyId';
        $privateKeyFile = null;

        // Test
        new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
    }
}
