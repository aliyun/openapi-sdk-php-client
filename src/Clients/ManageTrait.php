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

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider;
use AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\StsCredential;

/**
 * Trait ManageTrait.
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin     Client
 */
trait ManageTrait
{

    /**
     * @param int $timeout
     *
     * @return AccessKeyCredential|CredentialsInterface|StsCredential
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function getSessionCredential($timeout = \ALIBABA_CLOUD_TIMEOUT)
    {
        switch (\get_class($this->credential)) {
            case EcsRamRoleCredential::class:
                return (new EcsRamRoleProvider($this))->get();
            case RamRoleArnCredential::class:
                return (new RamRoleArnProvider($this))->get($timeout);
            case RsaKeyPairCredential::class:
                return (new RsaKeyPairProvider($this))->get($timeout);
            default:
                return $this->credential;
        }
    }

    /**
     * Naming clients.
     *
     * @param string $clientName
     *
     * @return static
     */
    public function name($clientName)
    {
        return AlibabaCloud::set($clientName, $this);
    }

    /**
     * Set the current client as the global client.
     *
     * @return static
     */
    public function asGlobalClient()
    {
        return $this->name(\ALIBABA_CLOUD_GLOBAL_CLIENT);
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
