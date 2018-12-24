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
 * PHP version 5
 *
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit\Client\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Providers\IniCredentialProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class IniCredentialProviderTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\IniCredentialProvider
 */
class IniCredentialProviderTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::del('phpunit');
        IniCredentialProvider::forgetLoadedCredentialsFile();
    }

    /**
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
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage       Format error: vfs://AlibabaCloud/credentials
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
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage       Credential file is not readable: /root/AlibabaCloud/NoneFile
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
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'type' option for 'phpunit' in vfs://AlibabaCloud/credentials
     */
    public function testNoType()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::noType());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Invalid type 'invalidType' for 'phpunit' in vfs://AlibabaCloud/credentials
     */
    public function testInvalidType()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::invalidType());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'access_key_id' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
     */
    public function testNoKey()
    {
        AlibabaCloud::load(VirtualAccessKeyCredential::noKey());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'access_key_secret' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
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
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'role_name' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
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
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'access_key_id' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
     */
    public function testRamRoleArnClientNoKey()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::noKey());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'access_key_secret' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
     */
    public function testRamRoleArnClientNoSecret()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::noSecret());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'role_arn' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
     */
    public function testRamRoleArnClientNoRoleArn()
    {
        AlibabaCloud::load(VirtualRamRoleArnCredential::noRoleArn());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'role_session_name' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
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
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'bearer_token' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
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
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'public_key_id' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
     */
    public function testNoPublicKeyId()
    {
        AlibabaCloud::load(VirtualRsaKeyPairCredential::noPublicKeyId());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       Missing required 'private_key_file' option for 'phpunit' in
     *                                 vfs://AlibabaCloud/credentials
     */
    public function testNoPrivateKeyFile()
    {
        AlibabaCloud::load(VirtualRsaKeyPairCredential::noPrivateKeyFile());
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionCode          0
     * @expectedExceptionMessage       file_get_contents(/bad/path.pem): failed to open stream: No such file or
     *                                 directory
     */
    public function testBadPrivateKeyFilePath()
    {
        AlibabaCloud::load(VirtualRsaKeyPairCredential::badPrivateKeyFilePath());
    }

    /**
     * @throws \ReflectionException
     * @covers ::getHomeDirectory
     */
    public function testGetsHomeDirectoryForWindowsUsers()
    {
        putenv('HOME=');
        putenv('HOMEDRIVE=C:');
        putenv('HOMEPATH=\\Users\\Alibaba');
        $ref  = new \ReflectionClass(IniCredentialProvider::class);
        $meth = $ref->getMethod('getHomeDirectory');
        $meth->setAccessible(true);
        $this->assertEquals('C:\\Users\\Alibaba', $meth->invoke(null));
    }
}
