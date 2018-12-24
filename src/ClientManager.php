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

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider;
use AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Signature\SignatureInterface;

/**
 * Class ClientManager
 *
 * @package   \AlibabaCloud\Client
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/aliyun-openapi-php-sdk
 * @mixin     AlibabaCloud
 */
trait ClientManager
{
    /**
     * Get the Client instance by name.
     *
     * @param string $clientName
     *
     * @return array|self
     * @throws ClientException
     */
    public static function get($clientName)
    {
        if (self::has($clientName)) {
            return self::$clients[\strtolower($clientName)];
        }
        throw new ClientException(ALIBABA_CLOUD
                                  . ' Client Not Found: '
                                  . $clientName, \ALI_CLIENT_NOT_FOUND);
    }

    /**
     * Get all clients.
     *
     * @return array
     */
    public static function all()
    {
        return self::$clients;
    }

    /**
     * Delete the client by specifying name.
     *
     * @param string $name
     */
    public static function del($name)
    {
        unset(self::$clients[\strtolower($name)]);
    }

    /**
     * Delete all clients.
     *
     * @return void
     */
    public static function flush()
    {
        self::$clients        = [];
        self::$globalRegionId = null;
    }

    /**
     * Naming clients.
     *
     * @param string $clientName
     *
     * @return AlibabaCloud
     */
    public function name($clientName)
    {
        return self::$clients[\strtolower($clientName)] =& $this;
    }

    /**
     * Set the current client as the global client.
     *
     * @return self
     */
    public function asGlobalClient()
    {
        return $this->name(\ALIBABA_CLOUD_GLOBAL_CLIENT);
    }

    /**
     * Get the global client.
     *
     * @return AlibabaCloud|array
     * @throws ClientException
     */
    public static function getGlobalClient()
    {
        return self::get(\ALIBABA_CLOUD_GLOBAL_CLIENT);
    }

    /**
     * Determine whether there is a client.
     *
     * @param string $clientName
     *
     * @return bool
     */
    public static function has($clientName)
    {
        return isset(self::$clients[\strtolower($clientName)]);
    }

    /**
     * @return SignatureInterface
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return CredentialsInterface|AccessKeyCredential|BearerTokenCredential|StsCredential|EcsRamRoleCredential|RamRoleArnCredential
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * Set the Global default RegionId.
     *
     * @param string $globalRegionId
     */
    public static function setGlobalRegionId($globalRegionId)
    {
        self::$globalRegionId = $globalRegionId;
    }

    /**
     * Get the Global default RegionId.
     *
     * @return string|null
     */
    public static function getGlobalRegionId()
    {
        return self::$globalRegionId;
    }

    /**
     * @param int $timeout
     *
     * @return AccessKeyCredential|BearerTokenCredential|StsCredential|CredentialsInterface
     * @throws ClientException
     * @throws ServerException
     */
    public function getSessionCredential($timeout = \ALIBABA_CLOUD_TIMEOUT)
    {
        if ($this->credential instanceof RamRoleArnCredential) {
            return (new RamRoleArnProvider($this, $timeout))->getSessionCredential();
        }

        if ($this->credential instanceof EcsRamRoleCredential) {
            return (new EcsRamRoleProvider($this, $timeout))->getSessionCredential();
        }

        if ($this->credential instanceof RsaKeyPairCredential) {
            return (new RsaKeyPairProvider($this, $timeout))->getSessionCredential();
        }

        return $this->credential;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        if (isset($this->options['debug'])) {
            return $this->options['debug'] === true && PHP_SAPI === 'cli';
        }

        return false;
    }
}
