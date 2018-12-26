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

namespace AlibabaCloud\Client\Credentials\Ini;

use AlibabaCloud\Client\Clients\AccessKeyClient;
use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Trait CreateTrait
 *
 * @package   AlibabaCloud\Client\Credentials\Ini
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin     IniCredential
 */
trait CreateTrait
{
    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @return Client|bool
     * @throws ClientException
     */
    protected function createClient($clientName, array $credential)
    {
        if (isset($credential['enable']) && !$credential['enable']) {
            return false;
        }

        if (!isset($credential['type'])) {
            self::missingRequired('type', $clientName);
        }

        return $this->createClientByType($clientName, $credential)->name($clientName);
    }

    /**
     * @param       $clientName
     * @param array $credential
     *
     * @return AccessKeyClient|BearerTokenClient|EcsRamRoleClient|RamRoleArnClient|RsaKeyPairClient
     * @throws ClientException
     */
    private function createClientByType($clientName, array $credential)
    {
        switch (\strtolower($credential['type'])) {
            case 'access_key':
                return $this->accessKeyClient($clientName, $credential);
            case 'ecs_ram_role':
                return $this->ecsRamRoleClient($clientName, $credential);
            case 'ram_role_arn':
                return $this->ramRoleArnClient($clientName, $credential);
            case 'bearer_token':
                return $this->bearerTokenClient($clientName, $credential);
            case 'rsa_key_pair':
                return $this->rsaKeyPairClient($clientName, $credential);
            default:
                throw new ClientException(
                    "Invalid type '{$credential['type']}' for '$clientName' in {$this->filename}",
                    \ALI_INVALID_CREDENTIAL
                );
        }
    }

    /**
     * @param array  $credential
     * @param string $clientName
     *
     * @return RsaKeyPairClient
     * @throws ClientException
     */
    private function rsaKeyPairClient($clientName, array $credential)
    {
        if (!isset($credential['public_key_id'])) {
            self::missingRequired('public_key_id', $clientName);
        }

        if (!isset($credential['private_key_file'])) {
            self::missingRequired('private_key_file', $clientName);
        }

        return new RsaKeyPairClient(
            $credential['public_key_id'],
            $credential['private_key_file']
        );
    }

    /**
     * @param array  $credential
     * @param string $clientName
     *
     * @return AccessKeyClient
     * @throws ClientException
     */
    private function accessKeyClient($clientName, array $credential)
    {
        if (!isset($credential['access_key_id'])) {
            self::missingRequired('access_key_id', $clientName);
        }

        if (!isset($credential['access_key_secret'])) {
            self::missingRequired('access_key_secret', $clientName);
        }

        return new AccessKeyClient(
            $credential['access_key_id'],
            $credential['access_key_secret']
        );
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @return EcsRamRoleClient
     * @throws ClientException
     */
    private function ecsRamRoleClient($clientName, array $credential)
    {
        if (!isset($credential['role_name'])) {
            self::missingRequired('role_name', $clientName);
        }

        return new EcsRamRoleClient($credential['role_name']);
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @return RamRoleArnClient
     * @throws ClientException
     */
    private function ramRoleArnClient($clientName, array $credential)
    {
        if (!isset($credential['access_key_id'])) {
            self::missingRequired('access_key_id', $clientName);
        }

        if (!isset($credential['access_key_secret'])) {
            self::missingRequired('access_key_secret', $clientName);
        }

        if (!isset($credential['role_arn'])) {
            self::missingRequired('role_arn', $clientName);
        }

        if (!isset($credential['role_session_name'])) {
            self::missingRequired('role_session_name', $clientName);
        }

        return new RamRoleArnClient(
            $credential['access_key_id'],
            $credential['access_key_secret'],
            $credential['role_arn'],
            $credential['role_session_name']
        );
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @return BearerTokenClient
     * @throws ClientException
     */
    private function bearerTokenClient($clientName, array $credential)
    {
        if (!isset($credential['bearer_token'])) {
            self::missingRequired('bearer_token', $clientName);
        }

        return new BearerTokenClient($credential['bearer_token']);
    }
}
