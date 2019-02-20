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

    public function setUp()
    {
        parent::setUp();
        self::$regionId        = 'cn-hangzhou';
        self::$accessKeyId     = \getenv('ACCESS_KEY_ID');
        self::$accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        self::$roleName        = \getenv('ECS_ROLE_NAME');
        self::$roleArn         = \getenv('ROLE_ARN');
        self::$roleSessionName = \getenv('ROLE_SESSION_NAME');
        self::$bearerToken     = 'BEARER_TOKEN';
    }

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
        AlibabaCloud::accessKeyClient(self::$accessKeyId, self::$accessKeyId)->asGlobalClient();
        $credential = AlibabaCloud::getGlobalClient()->getCredential();
        self::assertInstanceOf(AccessKeyCredential::class, $credential);
        self::assertEquals(self::$accessKeyId, $credential->getAccessKeyId());
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
        )->asGlobalClient();

        $credential = AlibabaCloud::getGlobalClient()->getCredential();
        self::assertInstanceOf(RamRoleArnCredential::class, $credential);
        self::assertEquals(self::$accessKeyId, $credential->getAccessKeyId());
        self::assertEquals(self::$accessKeySecret, $credential->getAccessKeySecret());
        self::assertEquals(self::$roleArn, $credential->getRoleArn());
        self::assertEquals(self::$roleSessionName, $credential->getRoleSessionName());
    }

    /**
     * @throws ClientException
     */
    public function testEcsRamRoleClient()
    {
        AlibabaCloud::ecsRamRoleClient(self::$roleName)->asGlobalClient();
        $credential = AlibabaCloud::getGlobalClient()->getCredential();
        self::assertInstanceOf(EcsRamRoleCredential::class, $credential);
        self::assertEquals(self::$roleName, $credential->getRoleName());
    }

    /**
     * @throws ClientException
     */
    public function testBearerTokenClient()
    {
        AlibabaCloud::bearerTokenClient(self::$bearerToken)->asGlobalClient();

        $credential = AlibabaCloud::getGlobalClient()->getCredential();
        self::assertInstanceOf(BearerTokenCredential::class, $credential);
        self::assertEquals('', $credential->getAccessKeyId());
        self::assertEquals('', $credential->getAccessKeySecret());
        self::assertEquals(self::$bearerToken, $credential->getBearerToken());
    }

    public function testStsClient()
    {
        AlibabaCloud::stsClient('key', 'secret', 'token')->name('sts');
        self::assertInstanceOf(StsCredential::class, AlibabaCloud::get('sts')->getCredential());
    }

    public function testRsaKeyPairClient()
    {
        AlibabaCloud::rsaKeyPairClient('key', VirtualAccessKeyCredential::ok())
                    ->name('rsa');

        self::assertInstanceOf(
            RsaKeyPairCredential::class,
            AlibabaCloud::get('rsa')->getCredential()
        );
    }

    public function testGet()
    {
        // setup
        $rand = \mt_rand(1, 10000);
        AlibabaCloud::accessKeyClient($rand, \time())->name('client1');
        $this->assertEquals(
            $rand,
            AlibabaCloud::get('client1')->getCredential()->getAccessKeyId()
        );

        try {
            AlibabaCloud::get('None')->getCredential()->getAccessKeyId();
        } catch (ClientException $e) {
            $this->assertEquals(\ALIBABA_CLOUD_CLIENT_NOT_FOUND, $e->getErrorCode());
        }
    }

    public function testIsDebug()
    {
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client1');
        AlibabaCloud::get('client1')->debug(true);
        self::assertTrue(AlibabaCloud::get('client1')->isDebug());
    }

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client not found: global
     * @throws                   ClientException
     */
    public static function testGetGlobalClient()
    {
        AlibabaCloud::flush();
        AlibabaCloud::getGlobalClient();
    }

    public function testGetSignature()
    {
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client1');
        $this->assertInstanceOf(ShaHmac1Signature::class, AlibabaCloud::get('client1')->getSignature());
    }

    /**
     * @covers ::del
     * @covers ::has
     */
    public function testDel()
    {
        // Setup
        $clientName = 'test';

        AlibabaCloud::accessKeyClient(\time(), \time())->name($clientName);
        $this->assertEquals(true, AlibabaCloud::has($clientName));
        AlibabaCloud::del($clientName);
        $this->assertEquals(false, AlibabaCloud::has($clientName));
    }

    public function testAll()
    {
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client1');
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client2');
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client3');
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
}
