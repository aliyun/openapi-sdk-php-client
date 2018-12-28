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
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class AlibabaCloudTest
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

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testLoad()
    {
        AlibabaCloud::load();
        $this->assertNotNull(AlibabaCloud::all());
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
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
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Credential file is not readable: /no/no
     * @throws                   \AlibabaCloud\Client\Exception\ClientException
     */
    public function testLoadWithException()
    {
        AlibabaCloud::load('/no/no');
    }

    /**
     * @covers ::getGlobalRegionId
     * @covers ::setGlobalRegionId
     */
    public function testGlobalRegionId()
    {
        // Setup
        $regionId = 'test';
        $this->assertNull(AlibabaCloud::getGlobalRegionId());

        // Test
        AlibabaCloud::setGlobalRegionId($regionId);

        // Assert
        $this->assertEquals($regionId, AlibabaCloud::getGlobalRegionId());
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
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Alibaba Cloud Client Not Found: global
     * @throws                   ClientException
     */
    public function testGetGlobalClient()
    {
        AlibabaCloud::flush();
        AlibabaCloud::getGlobalClient();
    }

    /**
     * @covers ::get
     */
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
            $this->assertEquals(\ALI_CLIENT_NOT_FOUND, $e->getErrorCode());
        }
    }

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
