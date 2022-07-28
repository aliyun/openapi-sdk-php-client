<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualAccessKeyCredential;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualRamRoleArnCredential;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualEcsRamRoleCredential;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualBearerTokenCredential;

/**
 * Class IniCredentialFeatureTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Ini\IniCredential
 */
class IniCredentialFeatureTest extends TestCase
{

    public function testBadFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Format error: vfs://AlibabaCloud/credentials-1');
        AlibabaCloud::load(VirtualAccessKeyCredential::badFormat());
    }

    public function testLoadCredentialsFile()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessageMatches("/Credential file is not readable: \w+/");
        AlibabaCloud::load('no/file');
    }

    public function testLoadDirectory()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Credential file is not readable: /root/AlibabaCloud/NoneFile');
        AlibabaCloud::load('/root/AlibabaCloud/NoneFile');
    }

    /**
     * @throws ClientException
     */
    public function testDisableClient()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::disable());
        self::assertFalse(AlibabaCloud::has('phpunit'));
    }

    public function testNoType()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'type' option for 'phpunit'");
        AlibabaCloud::load(VirtualAccessKeyCredential::noType());
    }

    public function testInvalidType()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Invalid type 'invalidType' for 'phpunit'");
        AlibabaCloud::load(VirtualAccessKeyCredential::invalidType());
    }

    public function testNoKey()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'access_key_id' option for 'phpunit'");
        AlibabaCloud::load(VirtualAccessKeyCredential::noKey());
    }

    public function testNoSecret()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'access_key_secret' option for 'phpunit'");
        AlibabaCloud::load(VirtualAccessKeyCredential::noSecret());
    }

    /**
     * @throws ClientException
     */
    public function tearDown(): void
    {
        AlibabaCloud::del('phpunit');
        IniCredential::forgetLoadedCredentialsFile();
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeyOk()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::ok());
        $client = AlibabaCloud::get('ok');
        self::assertEquals('foo', $client->getCredential()->getAccessKeyId());
        self::assertEquals('bar', $client->getCredential()->getAccessKeySecret());
        self::assertEquals(0.2, $client->options['timeout']);
        self::assertEquals(0.03, $client->options['connect_timeout']);
        self::assertEquals(true, $client->options['debug']);
        self::assertEquals('tcp://localhost:8125', $client->options['proxy']['http']);
        self::assertEquals('tcp://localhost:9124', $client->options['proxy']['https']);
        self::assertEquals(['.mit.edu', 'foo.com'], $client->options['proxy']['no']);
        self::assertEquals(['/path/server.pem', 'password'], $client->options['cert']);
        self::assertEquals('cn-hangzhou', $client->regionId);
    }

    /**
     * @throws ClientException
     */
    public function testEcsRamRoleClient()
    {
        AlibabaCloud::load(VirtualEcsRamRoleCredential::client());
        self::assertTrue(AlibabaCloud::has('phpunit'));
    }

    public function testEcsRamRoleClientNoRoleName()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'role_name' option for 'phpunit'");
        AlibabaCloud::load(VirtualEcsRamRoleCredential::noRoleName());
    }

    /**
     * @throws ClientException
     */
    public function testRamRoleArnClient()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::client());
        self::assertTrue(AlibabaCloud::has('phpunit'));
    }

    public function testRamRoleArnClientNoKey()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'access_key_id' option for 'phpunit'");
        AlibabaCloud::load(VirtualRamRoleArnCredential::noKey());
    }

    public function testRamRoleArnClientNoSecret()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'access_key_secret' option for 'phpunit'");
        AlibabaCloud::load(VirtualRamRoleArnCredential::noSecret());
    }

    public function testRamRoleArnClientNoRoleArn()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'role_arn' option for 'phpunit'");
        AlibabaCloud::load(VirtualRamRoleArnCredential::noRoleArn());
    }

    public function testRamRoleArnClientNoRoleSessionName()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'role_session_name' option for 'phpunit'");
        AlibabaCloud::load(VirtualRamRoleArnCredential::noRoleSessionName());
    }

    /**
     * @throws ClientException
     */
    public function testBearerTokenClient()
    {
        AlibabaCloud::load(VirtualBearerTokenCredential::client());
        self::assertTrue(AlibabaCloud::has('phpunit'));
    }

    public function testBearerTokenClientNoToken()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'bearer_token' option for 'phpunit'");
        AlibabaCloud::load(VirtualBearerTokenCredential::noToken());
    }

    /**
     * @throws ClientException
     */
    public function testAkClientWithAttributes()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::akClientWithAttributes('akClientWithAttributes'));
        AlibabaCloud::load(VirtualAccessKeyCredential::akClientWithAttributesNoCertPassword('NoCertPassword'));
        static::assertTrue(AlibabaCloud::has('akClientWithAttributes'));
        static::assertFalse(AlibabaCloud::has('NoCertPassword'));
    }

    /**
     * @throws ClientException
     */
    public function testAkClientWithAttributesNoCertPassword()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::akClientWithAttributesNoCertPassword('NoCertPassword'));
        static::assertTrue(AlibabaCloud::has('NoCertPassword'));
    }

    public function testNoPublicKeyId()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'public_key_id' option for 'phpunit'");
        AlibabaCloud::load(VirtualRsaKeyPairCredential::noPublicKeyId());
    }

    public function testNoPrivateKeyFile()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Missing required 'private_key_file' option for 'phpunit'");
        AlibabaCloud::load(VirtualRsaKeyPairCredential::noPrivateKeyFile());
    }

    public function testBadPrivateKeyFilePath()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessageMatches("/file_get_contents/");
        AlibabaCloud::load(VirtualRsaKeyPairCredential::badPrivateKeyFilePath());
    }
}
