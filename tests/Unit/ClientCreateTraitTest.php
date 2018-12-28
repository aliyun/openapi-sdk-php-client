<?php

namespace AlibabaCloud\Client\Tests\Unit;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientCreateTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class ClientCreateTraitTest extends TestCase
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
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testAccessKeyClient()
    {
        AlibabaCloud::accessKeyClient(self::$accessKeyId, self::$accessKeyId)->asGlobalClient();
        $credential = AlibabaCloud::getGlobalClient()->getCredential();
        self::assertInstanceOf(AccessKeyCredential::class, $credential);
        self::assertEquals(self::$accessKeyId, $credential->getAccessKeyId());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
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
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testEcsRamRoleClient()
    {
        AlibabaCloud::ecsRamRoleClient(self::$roleName)->asGlobalClient();
        $credential = AlibabaCloud::getGlobalClient()->getCredential();
        self::assertInstanceOf(EcsRamRoleCredential::class, $credential);
        self::assertEquals(self::$roleName, $credential->getRoleName());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
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
}
