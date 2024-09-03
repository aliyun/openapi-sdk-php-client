<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\SDK;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

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
     * @before
     */
    public function initialize()
    {
        parent::setUp();
        self::$regionId = 'cn-hangzhou';
        self::$accessKeyId = \getenv('ACCESS_KEY_ID');
        self::$accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        self::$roleName = 'EcsRamRoleTest';
        self::$roleArn = 'acs:ram::1483445870618637:role/test';
        self::$roleSessionName = 'role_session_name';
        self::$bearerToken = 'BEARER_TOKEN';
    }

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
     * @throws                   ClientException
     */
    public function testGetDefaultClient()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client 'default' not found");
        AlibabaCloud::flush();
        AlibabaCloud::getDefaultClient();
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
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeyIdEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey ID cannot be empty");
        AlibabaCloud::accessKeyClient(
            '',
            self::$accessKeySecret
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeyIdFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey ID format is invalid");
        AlibabaCloud::accessKeyClient(
            null,
            self::$accessKeySecret
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeySecretEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey Secret cannot be empty");
        AlibabaCloud::accessKeyClient(
            self::$accessKeyId,
            ''
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeyClientWithAccessKeySecretFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey Secret format is invalid");
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
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeyIdEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey ID cannot be empty");
        AlibabaCloud::ramRoleArnClient(
            '',
            self::$accessKeySecret,
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeyIdFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey ID must be a string");
        AlibabaCloud::ramRoleArnClient(
            null,
            self::$accessKeySecret,
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeySecretEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey Secret cannot be empty");
        AlibabaCloud::ramRoleArnClient(
            self::$accessKeyId,
            '',
            self::$roleArn,
            self::$roleSessionName
        )->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testRamRoleArnClientWithAccessKeySecretFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey Secret must be a string");
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
     * @throws ClientException
     */
    public function testEcsRamRoleClientEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Role Name cannot be empty");
        AlibabaCloud::ecsRamRoleClient('')->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testEcsRamRoleClientFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Role Name must be a string");
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
     * @throws ClientException
     */
    public function testBearerTokenClientEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Bearer Token cannot be empty");
        AlibabaCloud::bearerTokenClient('')->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testBearerTokenClientFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Bearer Token must be a string");
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
     * @throws ClientException
     */
    public function testStsClientWithPublicKeyIdEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey ID cannot be empty");
        AlibabaCloud::stsClient('', 'secret')
            ->name('sts');
    }

    /**
     * @throws ClientException
     */
    public function testStsClientWithPublicKeyIdFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey ID must be a string");
        AlibabaCloud::stsClient(null, 'secret')
            ->name('sts');
    }

    /**
     * @throws ClientException
     */
    public function testStsClientWithPrivateKeyFileEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey Secret cannot be empty");
        AlibabaCloud::stsClient('key', '')
            ->name('sts');
    }

    /**
     * @throws ClientException
     */
    public function testStsClientWithPrivateKeyFileFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey Secret must be a string");
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
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPublicKeyIdEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Public Key ID cannot be empty");
        AlibabaCloud::rsaKeyPairClient('', 'privateKeyFile')
            ->name('rsa');
    }

    /**
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPublicKeyIdFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Public Key ID must be a string");
        AlibabaCloud::rsaKeyPairClient(null, 'privateKeyFile')
            ->name('rsa');
    }

    /**
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPrivateKeyFileEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Private Key File cannot be empty");
        AlibabaCloud::rsaKeyPairClient('publicKeyId', '')
            ->name('rsa');
    }

    /**
     * @throws ClientException
     */
    public function testRsaKeyPairClientWithPrivateKeyFileFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Private Key File must be a string");
        AlibabaCloud::rsaKeyPairClient('publicKeyId', null)
            ->name('rsa');
    }

    /**
     * @throws ClientException
     */
    public function testGet()
    {
        
        // setup
        $accessKeyId = uniqid('', true);
        $accessKeySecret = uniqid('', true);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client1');
        static::assertEquals(
            $accessKeyId,
            AlibabaCloud::get('client1')->getCredential()->getAccessKeyId()
        );

        try {
            AlibabaCloud::get('None')->getCredential()->getAccessKeyId();
        } catch (ClientException $e) {
            static::assertEquals(SDK::CLIENT_NOT_FOUND, $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testIsDebug()
    {
        
        $accessKeyId = uniqid('', true);
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
        
        $accessKeyId = uniqid('', true);
        $accessKeySecret = uniqid('', true);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client1');
        static::assertInstanceOf(ShaHmac1Signature::class, AlibabaCloud::get('client1')->getSignature());
    }

    /**
     * @throws ClientException
     */
    public function testDel()
    {
        
        // Setup
        $clientName = 'test';
        $accessKeyId = uniqid('', true);
        $accessKeySecret = uniqid('', true);

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name($clientName);
        static::assertEquals(true, AlibabaCloud::has($clientName));
        AlibabaCloud::del($clientName);
        static::assertEquals(false, AlibabaCloud::has($clientName));
    }

    /**
     * @throws ClientException
     */
    public function testAll()
    {
        
        $accessKeyId = uniqid('', true);
        $accessKeySecret = uniqid('', true);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client1');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client2');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->name('client3');
        static::assertArrayHasKey('client3', AlibabaCloud::all());
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
        static::assertNotNull(AlibabaCloud::all());
    }

    /**
     * @throws ClientException
     */
    public function testLoad()
    {
        
        AlibabaCloud::load();
        static::assertNotNull(AlibabaCloud::all());
    }

    /**
     *
     * @throws ClientException
     */
    public function testDelEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name cannot be empty");
        AlibabaCloud::del('');
    }

    /**
     *
     * @throws ClientException
     */
    public function testDelFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name must be a string");
        AlibabaCloud::del(null);
    }

    /**
     *
     * @throws ClientException
     */
    public function testHasEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name cannot be empty");
        AlibabaCloud::has('');
    }

    /**
     *
     * @throws ClientException
     */
    public function testHasFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name must be a string");
        AlibabaCloud::has(null);
    }

    /**
     *
     * @throws ClientException
     */
    public function testSetEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name cannot be empty");
        AlibabaCloud::set('', AlibabaCloud::bearerTokenClient('token'));
    }

    /**
     *
     * @throws ClientException
     */
    public function testSetFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name must be a string");
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
     *
     * @throws ClientException
     */
    public function testGetEmpty()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name cannot be empty");
        AlibabaCloud::get('');
    }

    /**
     *
     * @throws ClientException
     */
    public function testGetFormat()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client Name must be a string");
        AlibabaCloud::get(null);
    }

    /**
     *
     * @throws ClientException
     */
    public function testGetNotFound()
    {
        
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client 'notFound' not found");
        AlibabaCloud::get('notFound');
    }
}
