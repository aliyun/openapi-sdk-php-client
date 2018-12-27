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

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class ClientTest extends TestCase
{

    /**
     * @return Client
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = 'bar';
        $credential      = new AccessKeyCredential($accessKeyId, $accessKeySecret);
        $signature       = new ShaHmac256WithRsaSignature();

        // Test
        $client = new Client($credential, $signature);

        // Assert
        self::assertEquals($signature, $client->getSignature());
        self::assertEquals($credential, $client->getCredential());
        self::assertEquals($accessKeyId, $client->getCredential()->getAccessKeyId());
        self::assertEquals($accessKeySecret, $client->getCredential()->getAccessKeySecret());

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testName(Client $client)
    {
        // Setup
        $name = \uniqid('', false);

        // Test
        $client->name($name);

        // Assert
        self::assertEquals($client, AlibabaCloud::get($name));
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testAsGlobalClient(Client $client)
    {
        // Setup
        $name = \ALIBABA_CLOUD_GLOBAL_CLIENT;

        // Test
        $client->asGlobalClient();

        // Assert
        self::assertEquals($client, AlibabaCloud::get($name));
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     */
    public function testIsDebug(Client $client)
    {
        // Assert
        self::assertEquals(false, $client->isDebug());

        // Test
        $client->debug(true);

        // Assert
        self::assertEquals(true, $client->isDebug());
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(Client $client)
    {
        self::assertInstanceOf(AccessKeyCredential::class, $client->getSessionCredential());
    }
}
