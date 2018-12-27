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

use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use PHPUnit\Framework\TestCase;

/**
 * Class EcsRamRoleClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class EcsRamRoleClientTest extends TestCase
{

    /**
     * @return EcsRamRoleClient
     */
    public function testConstruct()
    {
        // Setup
        $roleName = 'foo';

        // Test
        $client = new EcsRamRoleClient($roleName);

        // Assert
        self::assertEquals($roleName, $client->getCredential()->getRoleName());
        self::assertInstanceOf(EcsRamRoleCredential::class, $client->getCredential());
        self::assertInstanceOf(ShaHmac1Signature::class, $client->getSignature());

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param EcsRamRoleClient $client
     *
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(EcsRamRoleClient $client)
    {
        try {
            $client->getSessionCredential(1000);
        } catch (ClientException $exception) {
            self::assertEquals($exception->getErrorCode(), \ALI_SERVER_UNREACHABLE);
        }
    }
}
