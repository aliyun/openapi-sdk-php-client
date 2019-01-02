<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualBearerTokenCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualEcsRamRoleCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRamRoleArnCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class IniCredentialFeatureTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Ini\IniCredential
 */
class IniCredentialFeatureTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::del('phpunit');
        IniCredential::forgetLoadedCredentialsFile();
    }

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
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Format error: vfs://AlibabaCloud/credentials
     */
    public function testBadFormat()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::badFormat());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessageRegExp /Credential file is not readable: \w+/
     */
    public function testLoadCredentialsFile()
    {
        AlibabaCloud::load('no/file');
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Credential file is not readable: /root/AlibabaCloud/NoneFile
     */
    public function testLoadDirectory()
    {
        AlibabaCloud::load('/root/AlibabaCloud/NoneFile');
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testDisableClient()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::disable());
        self::assertFalse(AlibabaCloud::has('phpunit'));
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'type' option for 'phpunit'
     */
    public function testNoType()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::noType());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Invalid type 'invalidType' for 'phpunit'
     */
    public function testInvalidType()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::invalidType());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'access_key_id' option for 'phpunit'
     */
    public function testNoKey()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::noKey());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'access_key_secret' option for 'phpunit'
     */
    public function testNoSecret()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::noSecret());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testEcsRamRoleClient()
    {
        AlibabaCloud::load(VirtualEcsRamRoleCredential::client());
        self::assertTrue(AlibabaCloud::has('phpunit'));
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'role_name' option for 'phpunit'
     */
    public function testEcsRamRoleClientNoRoleName()
    {
        AlibabaCloud::load(VirtualEcsRamRoleCredential::noRoleName());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testRamRoleArnClient()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::client());
        self::assertTrue(AlibabaCloud::has('phpunit'));
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'access_key_id' option for 'phpunit'
     */
    public function testRamRoleArnClientNoKey()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::noKey());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'access_key_secret' option for 'phpunit'
     */
    public function testRamRoleArnClientNoSecret()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::noSecret());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'role_arn' option for 'phpunit'
     */
    public function testRamRoleArnClientNoRoleArn()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::noRoleArn());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'role_session_name' option for 'phpunit'
     */
    public function testRamRoleArnClientNoRoleSessionName()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::noRoleSessionName());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testBearerTokenClient()
    {
        AlibabaCloud::load(VirtualBearerTokenCredential::client());
        self::assertTrue(AlibabaCloud::has('phpunit'));
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'bearer_token' option for 'phpunit'
     */
    public function testBearerTokenClientNoToken()
    {
        AlibabaCloud::load(VirtualBearerTokenCredential::noToken());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testAkClientWithAttributes()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::akClientWithAttributes('akClientWithAttributes'));
        AlibabaCloud::load(VirtualAccessKeyCredential::akClientWithAttributesNoCertPassword('NoCertPassword'));
        $this->assertTrue(AlibabaCloud::has('akClientWithAttributes'));
        $this->assertFalse(AlibabaCloud::has('NoCertPassword'));
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testAkClientWithAttributesNoCertPassword()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::akClientWithAttributesNoCertPassword('NoCertPassword'));
        $this->assertTrue(AlibabaCloud::has('NoCertPassword'));
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'public_key_id' option for 'phpunit'
     */
    public function testNoPublicKeyId()
    {
        AlibabaCloud::load(VirtualRsaKeyPairCredential::noPublicKeyId());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Missing required 'private_key_file' option for 'phpunit'
     */
    public function testNoPrivateKeyFile()
    {
        AlibabaCloud::load(VirtualRsaKeyPairCredential::noPrivateKeyFile());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage file_get_contents(/bad/path.pem): failed to open stream: No such file or
     *                                 directory
     */
    public function testBadPrivateKeyFilePath()
    {
        AlibabaCloud::load(VirtualRsaKeyPairCredential::badPrivateKeyFilePath());
    }
}
