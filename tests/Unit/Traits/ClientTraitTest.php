<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\SDK;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\ClientTrait
 */
class ClientTraitTest extends TestCase
{
    /**
     * @var string
     */
    private static $accessKeyId;
    /**
     * @var string
     */
    private static $accessKeySecret;
    /**
     * @var string
     */
    private static $regionId;
    /**
     * @var string
     */
    private static $roleName;
    /**
     * @var string
     */
    private static $roleArn;
    /**
     * @var string
     */
    private static $roleSessionName;
    /**
     * @var string
     */
    private static $bearerToken;

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client 'default' not found
     * @throws                   ClientException
     */
    public static function testGetDefaultClient()
    {
        AlibabaCloud::flush();
        AlibabaCloud::getDefaultClient();
    }

    public function setUp()
    {
        parent::setUp();
        self::$regionId        = 'cn-hangzhou';
        self::$accessKeyId     = \getenv('ACCESS_KEY_ID');
        self::$accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        self::$roleName        = 'EcsRamRoleTest';
        self::$roleArn         = \getenv('ROLE_ARN');
        self::$roleSessionName = \getenv('ROLE_SESSION_NAME');
        self::$bearerToken     = 'BEARER_TOKEN';
    }

    /**
     * @throws ClientException
     */
    public function testClient()
    {
        AlibabaCloud::client(
            new AccessKeyCredential('foo', 'bar'),
            new ShaHmac256WithRsaSignature()
        )->name('client');

        self::assertInstanceOf(ShaHmac256WithRsaSignature::class, AlibabaCloud::get('client')->getSignature());
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeyClient()
    {
        AlibabaCloud::accessKeyClient(self::$accessKeyId, self::$accessKeyId)->asDefaultClient();
        $credential = AlibabaCloud::getDefaultClient()->getCredential();
        self::assertInstanceOf(AccessKeyCredential::class, $credential);
        self::assertEquals(self::$accessKeyId, $credential->getAccessKeyId());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID cannot be empty
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeyIdEmpty()
    {
        AlibabaCloud::accessKeyClient(
            '',
            self::$accessKeySecret
        )->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID must be a string
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeyIdFormat()
    {
        AlibabaCloud::accessKeyClient(
            null,
            self::$accessKeySecret
        )->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret cannot be empty
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeySecretEmpty()
    {
        AlibabaCloud::accessKeyClient(
            self::$accessKeyId,
            ''
        )->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret must be a string
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeySecretFormat()
    {
        AlibabaCloud::accessKeyClient(
            self::$accessKeyId,
            null
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testRamRoleArnClient()
    {
        AlibabaCloud::ramRoleArnClient(
            self::$accessKeyId,
            self::$accessKeySecret,
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();

        $credential = AlibabaCloud::getDefaultClient()->getCredential();
        self::assertInstanceOf(RamRoleArnCredential::class, $credential);
        self::assertEquals(self::$accessKeyId, $credential->getAccessKeyId());
        self::assertEquals(self::$accessKeySecret, $credential->getAccessKeySecret());
        self::assertEquals(self::$roleArn, $credential->getRoleArn());
        self::assertEquals(self::$roleSessionName, $credential->getRoleSessionName());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID cannot be empty
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeyIdEmpty()
    {
        AlibabaCloud::ramRoleArnClient(
            '',
            self::$accessKeySecret,
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID must be a string
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeyIdFormat()
    {
        AlibabaCloud::ramRoleArnClient(
            null,
            self::$accessKeySecret,
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret cannot be empty
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeySecretEmpty()
    {
        AlibabaCloud::ramRoleArnClient(
            self::$accessKeyId,
            '',
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret must be a string
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeySecretFormat()
    {
        AlibabaCloud::ramRoleArnClient(
            self::$accessKeyId,
            null,
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testEcsRamRoleClient()
    {
        AlibabaCloud::ecsRamRoleClient(self::$roleName)->asDefaultClient();
        $credential = AlibabaCloud::getDefaultClient()->getCredential();
        self::assertInstanceOf(EcsRamRoleCredential::class, $credential);
        self::assertEquals(self::$roleName, $credential->getRoleName());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Role Name cannot be empty
     * @throws ClientException
     */
    public function testEcsRamRoleClientEmpty()
    {
        AlibabaCloud::ecsRamRoleClient('')->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Role Name must be a string
     * @throws ClientException
     */
    public function testEcsRamRoleClientFormat()
    {
        AlibabaCloud::ecsRamRoleClient(null)->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testBearerTokenClient()
    {
        AlibabaCloud::bearerTokenClient(self::$bearerToken)->asDefaultClient();

        $credential = AlibabaCloud::getDefaultClient()->getCredential();
        self::assertInstanceOf(BearerTokenCredential::class, $credential);
        self::assertEquals('', $credential->getAccessKeyId());
        self::assertEquals('', $credential->getAccessKeySecret());
        self::assertEquals(self::$bearerToken, $credential->getBearerToken());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Bearer Token cannot be empty
     * @throws ClientException
     */
    public function testBearerTokenClientEmpty()
    {
        AlibabaCloud::bearerTokenClient('')->asDefaultClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Bearer Token must be a string
     * @throws ClientException
     */
    public function testBearerTokenClientFormat()
    {
        AlibabaCloud::bearerTokenClient(null)->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testStsClient()
    {
        AlibabaCloud::stsClient('key', 'secret', 'token')->name('sts');
        self::assertInstanceOf(StsCredential::class, AlibabaCloud::get('sts')->getCredential());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID cannot be empty
     * @throws ClientException
     */
    public function testStsClientWithPublicKeyIdEmpty()
    {
        AlibabaCloud::stsClient('', 'secret')
                    ->name('sts');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID must be a string
     * @throws ClientException
     */
    public function testStsClientWithPublicKeyIdFormat()
    {
        AlibabaCloud::stsClient(null, 'secret')
                    ->name('sts');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret cannot be empty
     * @throws ClientException
     */
    public function testStsClientWithPrivateKeyFileEmpty()
    {
        AlibabaCloud::stsClient('key', '')
                    ->name('sts');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret must be a string
     * @throws ClientException
     */
    public function testStsClientWithPrivateKeyFileFormat()
    {
        AlibabaCloud::stsClient('key', null)
                    ->name('sts');
    }

    /**
     * @throws ClientException
     */
    public function testRsaKeyPairClient()
    {
        AlibabaCloud::rsaKeyPairClient('key', VirtualAccessKeyCredential::ok())
                    ->name('rsa');

        self::assertInstanceOf(
            RsaKeyPairCredential::class,
            AlibabaCloud::get('rsa')->getCredential()
        );
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Public Key ID cannot be empty
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPublicKeyIdEmpty()
    {
        AlibabaCloud::rsaKeyPairClient('', 'privateKeyFile')
                    ->name('rsa');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Public Key ID must be a string
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPublicKeyIdFormat()
    {
        AlibabaCloud::rsaKeyPairClient(null, 'privateKeyFile')
                    ->name('rsa');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Private Key File cannot be empty
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPrivateKeyFileEmpty()
    {
        AlibabaCloud::rsaKeyPairClient('publicKeyId', '')
                    ->name('rsa');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Private Key File must be a string
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPrivateKeyFileFormat()
    {
        AlibabaCloud::rsaKeyPairClient('publicKeyId', null)
                    ->name('rsa');
    }

    /**
     * @throws ClientException
     */
    public function testGet()
    {
        // setup
        $accessKeyId     = uniqid('', true);
        $accessKeySecret = uniqid('', true);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client1');
        $this->assertEquals(
            $accessKeyId,
            AlibabaCloud::get('client1')->getCredential()->getAccessKeyId()
        );

        try {
            AlibabaCloud::get('None')->getCredential()->getAccessKeyId();
        } catch (ClientException $e) {
            $this->assertEquals(SDK::CLIENT_NOT_FOUND, $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testIsDebug()
    {
        $accessKeyId     = uniqid('', true);
        $accessKeySecret = uniqid('', true);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client1');
        AlibabaCloud::get('client1')->debug(true);
        self::assertTrue(AlibabaCloud::get('client1')->isDebug());
    }

    /**
     * @throws ClientException
     */
    public function testGetSignature()
    {
        $accessKeyId     = uniqid('', true);
        $accessKeySecret = uniqid('', true);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client1');
        $this->assertInstanceOf(ShaHmac1Signature::class, AlibabaCloud::get('client1')->getSignature());
    }

    /**
     * @throws ClientException
     */
    public function testDel()
    {
        // Setup
        $clientName      = 'test';
        $accessKeyId     = uniqid('', true);
        $accessKeySecret = uniqid('', true);

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name($clientName);
        $this->assertEquals(true, AlibabaCloud::has($clientName));
        AlibabaCloud::del($clientName);
        $this->assertEquals(false, AlibabaCloud::has($clientName));
    }

    /**
     * @throws ClientException
     */
    public function testAll()
    {
        $accessKeyId     = uniqid('', true);
        $accessKeySecret = uniqid('', true);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client1');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client2');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client3');
        $this->assertArrayHasKey('client3', AlibabaCloud::all());
    }

    /**
     * @throws ClientException
     */
    public function testLoadWithFiles()
    {
        AlibabaCloud::load(
            VirtualRsaKeyPairCredential::ok(),
            VirtualAccessKeyCredential::ok()
        );
        $this->assertNotNull(AlibabaCloud::all());
    }

    /**
     * @throws ClientException
     */
    public function testLoad()
    {
        AlibabaCloud::load();
        $this->assertNotNull(AlibabaCloud::all());
    }

    /**
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client Name cannot be empty
     *
     * @throws ClientException
     */
    public function testDelEmpty()
    {
        AlibabaCloud::del('');
    }

    /**
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client Name must be a string
     *
     * @throws ClientException
     */
    public function testDelFormat()
    {
        AlibabaCloud::del(null);
    }

    /**
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client Name cannot be empty
     *
     * @throws ClientException
     */
    public function testHasEmpty()
    {
        AlibabaCloud::has('');
    }

    /**
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client Name must be a string
     *
     * @throws ClientException
     */
    public function testHasFormat()
    {
        AlibabaCloud::has(null);
    }

    /**
     * @expectedExceptionMessage Client Name cannot be empty
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     *
     * @throws ClientException
     */
    public function testSetEmpty()
    {
        AlibabaCloud::set('', AlibabaCloud::bearerTokenClient('token'));
    }

    /**
     * @expectedExceptionMessage Client Name must be a string
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     *
     * @throws ClientException
     */
    public function testSetFormat()
    {
        AlibabaCloud::set(null, AlibabaCloud::bearerTokenClient('token'));
    }

    /**
     * @throws ClientException
     */
    public function testSet()
    {
        $name = uniqid('', true);
        AlibabaCloud::set($name, AlibabaCloud::bearerTokenClient('token'));
        self::assertTrue(AlibabaCloud::has($name));
        AlibabaCloud::del($name);
    }

    /**
     * @expectedExceptionMessage Client Name cannot be empty
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     *
     * @throws ClientException
     */
    public function testGetEmpty()
    {
        AlibabaCloud::get('');
    }

    /**
     * @expectedExceptionMessage Client Name must be a string
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     *
     * @throws ClientException
     */
    public function testGetFormat()
    {
        AlibabaCloud::get(null);
    }

    /**
     * @expectedExceptionMessage Client 'notFound' not found
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     *
     * @throws ClientException
     */
    public function testGetNotFound()
    {
        AlibabaCloud::get('notFound');
    }
}
