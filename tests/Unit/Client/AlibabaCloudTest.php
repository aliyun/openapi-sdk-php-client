<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * @category     AlibabaCloud
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit\Client;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use PHPUnit\Framework\TestCase;

/**
 * Class AlibabaCloudTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Client
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class AlibabaCloudTest extends TestCase
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

    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::flush();
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

    public function testStsClient()
    {
        AlibabaCloud::stsClient('key', 'secret', 'token')->name('sts');
        self::assertInstanceOf(StsCredential::class, AlibabaCloud::get('sts')->getCredential());
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
    public function testBearerTokenClient()
    {
        AlibabaCloud::bearerTokenClient(self::$bearerToken)->asGlobalClient();

        $credential = AlibabaCloud::getGlobalClient()->getCredential();
        self::assertInstanceOf(BearerTokenCredential::class, $credential);
        self::assertEquals('', $credential->getAccessKeyId());
        self::assertEquals('', $credential->getAccessKeySecret());
        self::assertEquals(self::$bearerToken, $credential->getBearerToken());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testLoad()
    {
        AlibabaCloud::load();
        $this->assertNotNull(AlibabaCloud::all());
    }

    /**
     * @covers ::getGlobalRegionId
     * @covers ::setGlobalRegionId
     */
    public function testGlobalRegionId()
    {
        $this->assertNull(AlibabaCloud::getGlobalRegionId());
        AlibabaCloud::setGlobalRegionId(\time());
        $this->assertEquals(\time(), AlibabaCloud::getGlobalRegionId());
    }

    /**
     * @covers ::del
     * @covers ::has
     */
    public function testDel()
    {
        AlibabaCloud::accessKeyClient(\time(), \time())->name(\time());
        $this->assertEquals(true, AlibabaCloud::has(\time()));
        AlibabaCloud::del(time());
        $this->assertEquals(false, AlibabaCloud::has(\time()));
    }

    /**
     * @covers ::all
     * @covers ::name
     */
    public function testAll()
    {
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client1');
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client2');
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client3');
        $this->assertArrayHasKey('client3', AlibabaCloud::all());
    }

    /**
     * @covers ::get
     */
    public function testGet()
    {
        $rand = \mt_rand(1, 10000);
        AlibabaCloud::accessKeyClient($rand, \time())->name('client1');
        $this->assertEquals($rand, AlibabaCloud::get('client1')->getCredential()->getAccessKeyId());

        try {
            AlibabaCloud::get('None')->getCredential()->getAccessKeyId();
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_CLIENT_NOT_FOUND, $e->getErrorCode());
        }
    }

    /**
     * @covers ::getSignature
     */
    public function testGetSignature()
    {
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client1');
        $this->assertInstanceOf(ShaHmac1Signature::class, AlibabaCloud::get('client1')->getSignature());
    }

    public function testIsDebug()
    {
        AlibabaCloud::accessKeyClient(\time(), \time())->name('client1');
        AlibabaCloud::get('client1')->debug(true);
        self::assertTrue(AlibabaCloud::get('client1')->isDebug());
    }
}
