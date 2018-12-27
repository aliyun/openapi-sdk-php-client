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

use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Signature\BearerTokenSignature;
use PHPUnit\Framework\TestCase;

/**
 * Class BearerTokenClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class BearerTokenClientTest extends TestCase
{

    /**
     * @return BearerTokenClient
     */
    public function testConstruct()
    {
        // Setup
        $bearerToken = 'bearerToken';

        // Test
        $client = new BearerTokenClient($bearerToken);

        // Assert
        self::assertEquals($bearerToken, $client->getCredential()->getBearerToken());
        self::assertInstanceOf(BearerTokenSignature::class, $client->getSignature());
        return $client;
    }

    /**
     * @depends                  testConstruct
     *
     * @param BearerTokenClient $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(BearerTokenClient $client)
    {
        self::assertInstanceOf(BearerTokenCredential::class, $client->getSessionCredential());
    }
}
