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

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\Clients\Client;

/**
 * Class Provider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class Provider
{
    /**
     * @var array
     */
    protected static $credentialsCache = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * CredentialTrait constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the toString of the credentials as the key.
     *
     * @return string
     */
    protected function key()
    {
        return (string)$this->client->getCredential();
    }

    /**
     * Cache credentials.
     *
     * @param mixed $result
     */
    protected function cache(array $result)
    {
        self::$credentialsCache[$this->key()] = $result;
    }

    /**
     * Get the credentials from the cache in the validity period.
     *
     * @return array|null
     */
    public function getCredentialsInCache()
    {
        if (isset(self::$credentialsCache[$this->key()])) {
            $result = self::$credentialsCache[$this->key()];
            if (\strtotime($result['Expiration']) - \time() >= ECS_ROLE_EXPIRE_TIME) {
                return $result;
            }
        }
        unset(self::$credentialsCache[$this->key()]);
        return null;
    }
}
