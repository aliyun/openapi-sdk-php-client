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
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class RsaKeyPairProviderTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Credentials\Providers
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider
 */
class RsaKeyPairProviderTest extends TestCase
{

    /**
     * @throws ClientException
     * @throws ServerException
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /openssl_sign/
     */
    public function testGet()
    {
        // Setup
        $client   = new RsaKeyPairClient(
            'foo',
            VirtualRsaKeyPairCredential::ok()
        );
        $provider = new RsaKeyPairProvider($client);

        // Test
        $actual = $provider->get();
        // Assert
        self::assertInstanceOf(AccessKeyCredential::class, $actual);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     * @throws \ReflectionException
     */
    public function testGetInCache()
    {
        // Setup
        $client   = new RsaKeyPairClient(
            'foo',
            VirtualRsaKeyPairCredential::ok()
        );
        $provider = new RsaKeyPairProvider($client);

        // Test
        $cacheMethod = new \ReflectionMethod(
            RsaKeyPairProvider::class,
            'cache'
        );
        $cacheMethod->setAccessible(true);
        $result = [
            'Expiration'             => '2020-02-02 11:11:11',
            'SessionAccessKeyId'     => 'foo',
            'SessionAccessKeySecret' => 'bar',
        ];
        $cacheMethod->invokeArgs($provider, [$result]);

        $actual = $provider->get();
        // Assert
        self::assertInstanceOf(AccessKeyCredential::class, $actual);
    }
}
