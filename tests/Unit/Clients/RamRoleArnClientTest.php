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
 * @category   AlibabaCloud
 *
 * @author     Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright  Alibaba Group
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link       https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use PHPUnit\Framework\TestCase;

/**
 * Class RamRoleClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RamRoleArnClientTest extends TestCase
{

    /**
     * @return RamRoleArnClient
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = '';
        $accessKeySecret = '';
        $roleArn         = '';
        $roleSessionName = '';

        // Test
        $client = new RamRoleArnClient($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName);

        // Assert
        self::assertInstanceOf(ShaHmac1Signature::class, $client->getSignature());
        self::assertInstanceOf(RamRoleArnCredential::class, $client->getCredential());
        self::assertEquals($accessKeyId, $client->getCredential()->getAccessKeyId());
        self::assertEquals($accessKeySecret, $client->getCredential()->getAccessKeySecret());
        self::assertEquals($roleArn, $client->getCredential()->getRoleArn());
        self::assertEquals($roleSessionName, $client->getCredential()->getRoleSessionName());

        return $client;
    }

    /**
     * @depends                  testConstruct
     *
     * @param RamRoleArnClient $client
     *
     */
    public function testGetSessionCredential(RamRoleArnClient $client)
    {
        try {
            $client->getSessionCredential();
        } catch (ServerException $exception) {
            self::assertEquals('AccessKeyId is mandatory for this action.', $exception->getErrorMessage());
        } catch (ClientException $exception) {
            self::assertStringStartsWith('cURL error', $exception->getErrorMessage());
        }
    }
}
