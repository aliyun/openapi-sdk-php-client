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

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class IniCredentialProvider
 *
 * @package AlibabaCloud\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */
class IniCredentialProvider
{

    /**
     * @var array
     */
    private static $hasLoaded;

    /**
     * @var string
     */
    protected $filename;

    /**
     * IniCredentialProvider constructor.
     *
     * @param string $filename
     */
    public function __construct($filename = '')
    {
        $this->filename = $filename ?: $this->getDefault();
    }

    /**
     * Gets the environment's HOME directory.
     *
     * @return null|string
     */
    private static function getHomeDirectory()
    {
        if (getenv('HOME')) {
            return getenv('HOME');
        }

        return (getenv('HOMEDRIVE') && getenv('HOMEPATH'))
            ? getenv('HOMEDRIVE') . getenv('HOMEPATH')
            : null;
    }

    /**
     * @return string
     */
    private function getDefault()
    {
        return self::getHomeDirectory() . '/.alibabacloud/credentials';
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @return AlibabaCloud|bool
     * @throws ClientException
     */
    private function createClient($clientName, array $credential)
    {
        if (isset($credential['enable']) && !$credential['enable']) {
            return false;
        }

        if (!isset($credential['type'])) {
            $this->missingRequired('type', $clientName);
        }

        switch (\strtolower($credential['type'])) {
            case 'access_key':
                return $this->accessKeyClient($credential, $clientName);
            case 'ecs_ram_role':
                return $this->ecsRamRoleClient($credential, $clientName);
            case 'ram_role_arn':
                return $this->ramRoleArnClient($credential, $clientName);
            case 'bearer_token':
                return $this->bearerTokenClient($credential, $clientName);
            case 'rsa_key_pair':
                return $this->rsaKeyPairClient($credential, $clientName);
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
     * @return AlibabaCloud
     * @throws ClientException
     */
    private function rsaKeyPairClient(array $credential, $clientName)
    {
        if (!isset($credential['public_key_id'])) {
            $this->missingRequired('public_key_id', $clientName);
        }

        if (!isset($credential['private_key_file'])) {
            $this->missingRequired('private_key_file', $clientName);
        }

        return AlibabaCloud::rsaKeyPairClient(
            $credential['public_key_id'],
            $credential['private_key_file']
        );
    }

    /**
     * @param array  $credential
     * @param string $clientName
     *
     * @return AlibabaCloud
     * @throws ClientException
     */
    private function accessKeyClient(array $credential, $clientName)
    {
        if (!isset($credential['access_key_id'])) {
            $this->missingRequired('access_key_id', $clientName);
        }

        if (!isset($credential['access_key_secret'])) {
            $this->missingRequired('access_key_secret', $clientName);
        }

        return AlibabaCloud::accessKeyClient(
            $credential['access_key_id'],
            $credential['access_key_secret']
        );
    }

    /**
     * @param array  $credential
     * @param string $clientName
     *
     * @return AlibabaCloud
     * @throws ClientException
     */
    private function ecsRamRoleClient(array $credential, $clientName)
    {
        if (!isset($credential['role_name'])) {
            $this->missingRequired('role_name', $clientName);
        }

        return AlibabaCloud::ecsRamRoleClient($credential['role_name']);
    }

    /**
     * @param array  $credential
     * @param string $clientName
     *
     * @return AlibabaCloud
     * @throws ClientException
     */
    private function ramRoleArnClient(array $credential, $clientName)
    {
        if (!isset($credential['access_key_id'])) {
            $this->missingRequired('access_key_id', $clientName);
        }

        if (!isset($credential['access_key_secret'])) {
            $this->missingRequired('access_key_secret', $clientName);
        }

        if (!isset($credential['role_arn'])) {
            $this->missingRequired('role_arn', $clientName);
        }

        if (!isset($credential['role_session_name'])) {
            $this->missingRequired('role_session_name', $clientName);
        }

        return AlibabaCloud::ramRoleArnClient(
            $credential['access_key_id'],
            $credential['access_key_secret'],
            $credential['role_arn'],
            $credential['role_session_name']
        );
    }

    /**
     * @param array  $credential
     * @param string $clientName
     *
     * @return AlibabaCloud
     * @throws ClientException
     */
    private function bearerTokenClient(array $credential, $clientName)
    {
        if (!isset($credential['bearer_token'])) {
            $this->missingRequired('bearer_token', $clientName);
        }

        return AlibabaCloud::bearerTokenClient($credential['bearer_token']);
    }

    /**
     * @param array  $client
     * @param string $key
     *
     * @return bool
     */
    private static function isNotEmpty($client, $key)
    {
        return isset($client[$key]) && !empty($client[$key]);
    }

    /**
     * @param string $clientName
     * @param array  $client
     *
     * @throws ClientException
     */
    private static function setClientAttributes($clientName, $client)
    {
        $options = [];
        if (self::isNotEmpty($client, 'region_id')) {
            AlibabaCloud::get($clientName)->regionId($client['region_id']);
        }
        if (isset($client['debug'])) {
            $options['debug'] = (bool)$client['debug'];
        }
        if (self::isNotEmpty($client, 'timeout')) {
            $options['timeout'] = $client['timeout'];
        }
        if (self::isNotEmpty($client, 'connect_timeout')) {
            $options['connect_timeout'] = $client['connect_timeout'];
        }
        if (self::isNotEmpty($client, 'proxy')) {
            $options['proxy'] = $client['proxy'];
        }
        if (self::isNotEmpty($client, 'cert_file') && !self::isNotEmpty($client, 'cert_password')) {
            $options['cert'] = $client['cert_file'];
        }
        if (self::isNotEmpty($client, 'cert_file') && self::isNotEmpty($client, 'cert_password')) {
            $options['cert'] = [$client['cert_file'], $client['cert_password']];
        }
        $proxy = [];
        if (self::isNotEmpty($client, 'proxy_http')) {
            $proxy['http'] = $client['proxy_http'];
        }
        if (self::isNotEmpty($client, 'proxy_https')) {
            $proxy['https'] = $client['proxy_https'];
        }
        if (self::isNotEmpty($client, 'proxy_no')) {
            $proxy['no'] = \explode(',', $client['proxy_no']);
        }
        if ($proxy !== []) {
            $options['proxy'] = $proxy;
        }

        AlibabaCloud::get($clientName)->options($options);
    }

    /**
     * @param string $key
     * @param string $clientName
     *
     * @throws ClientException
     */
    private function missingRequired($key, $clientName)
    {
        throw new ClientException(
            "Missing required '$key' option for '$clientName' in {$this->filename}",
            \ALI_INVALID_CREDENTIAL
        );
    }

    /**
     * @return void
     */
    public static function forgetLoadedCredentialsFile()
    {
        self::$hasLoaded = [];
    }

    /**
     * @return array|mixed
     * @throws ClientException
     */
    public function load()
    {
        /**----------------------------------------------------------------
         *   If it has been loaded, assign the client directly.
         *---------------------------------------------------------------*/
        if (isset(self::$hasLoaded[$this->filename])) {
            /**
             * @var $client AlibabaCloud
             */
            foreach (self::$hasLoaded[$this->filename] as $projectName => $client) {
                $client->name($projectName);
            }
            return self::$hasLoaded[$this->filename];
        }

        /**----------------------------------------------------------------
         *   Exceptions will be thrown
         *   if the file is unreadable and not the default file
         *---------------------------------------------------------------*/
        if (!\is_file($this->filename) || !\is_readable($this->filename)) {
            if ($this->filename === $this->getDefault()) {
                // @codeCoverageIgnoreStart
                return [];
                // @codeCoverageIgnoreEnd
            }
            throw new ClientException('Credential file is not readable: ' . $this->filename, \ALI_INVALID_CREDENTIAL);
        }

        try {
            $file = \parse_ini_file($this->filename, true);
            if (!$file || $file === false) {
                throw new ClientException('Format error: ' . $this->filename, \ALI_INVALID_CREDENTIAL);
            }
        } catch (\Exception $e) {
            throw new ClientException($e->getMessage(), \ALI_INVALID_CREDENTIAL, $e);
        }

        return $this->initClient($file);
    }

    /**
     * @param $file
     *
     * @return array|mixed
     * @throws ClientException
     */
    private function initClient($file)
    {
        foreach (\array_change_key_case($file) as $clientName => $clientConfigures) {
            $clientConfigures = \array_change_key_case($clientConfigures);
            $clientInstance   = $this->createClient($clientName, $clientConfigures);
            if ($clientInstance instanceof AlibabaCloud) {
                self::$hasLoaded[$this->filename][$clientName] = $clientInstance;
                $clientInstance->name($clientName);
                self::setClientAttributes($clientName, $clientConfigures);
            }
        }

        return isset(self::$hasLoaded[$this->filename])
            ? self::$hasLoaded[$this->filename]
            : [];
    }
}
