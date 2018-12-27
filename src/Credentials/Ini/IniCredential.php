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

use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class IniCredential
 *
 * @package   AlibabaCloud\Client\Credentials\Ini
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class IniCredential
{
    use CreateTrait;
    use OptionsTrait;

    /**
     * @var array
     */
    private static $hasLoaded;

    /**
     * @var string
     */
    protected $filename;

    /**
     * IniCredential constructor.
     *
     * @param string $filename
     */
    public function __construct($filename = '')
    {
        $this->filename = $filename ?: $this->getDefaultFile();
    }

    /**
     * Get the default credential file.
     *
     * @return string
     */
    public function getDefaultFile()
    {
        return self::getHomeDirectory() . '/.alibabacloud/credentials';
    }

    /**
     * Get the credential file.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
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
     * @param array  $array
     * @param string $key
     *
     * @return bool
     */
    protected static function isNotEmpty(array $array, $key)
    {
        return isset($array[$key]) && !empty($array[$key]);
    }

    /**
     * @param string $key
     * @param string $clientName
     *
     * @throws ClientException
     */
    public function missingRequired($key, $clientName)
    {
        throw new ClientException(
            "Missing required '$key' option for '$clientName' in " . $this->getFilename(),
            \ALI_INVALID_CREDENTIAL
        );
    }

    /**
     * Clear credential cache.
     *
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
        /**
         * ----------------------------------------------------------------
         *   If it has been loaded, assign the client directly.
         *---------------------------------------------------------------
         */
        if (isset(self::$hasLoaded[$this->filename])) {
            /**
             * @var $client Client
             */
            foreach (self::$hasLoaded[$this->filename] as $projectName => $client) {
                $client->name($projectName);
            }
            return self::$hasLoaded[$this->filename];
        }
        return $this->loadFile();
    }

    /**
     * Exceptions will be thrown if the file is unreadable and not the default file.
     *
     * @return array|mixed
     * @throws ClientException
     */
    private function loadFile()
    {
        if (!\is_file($this->filename) || !\is_readable($this->filename)) {
            if ($this->filename === $this->getDefaultFile()) {
                // @codeCoverageIgnoreStart
                return [];
                // @codeCoverageIgnoreEnd
            }
            throw new ClientException(
                'Credential file is not readable: ' . $this->getFilename(),
                \ALI_INVALID_CREDENTIAL
            );
        }

        return $this->parseFile();
    }

    /**
     * Decode the ini file into an array.
     *
     * @return array|mixed
     * @throws ClientException
     */
    private function parseFile()
    {
        try {
            $file = \parse_ini_file($this->filename, true);
            if (\is_array($file) && $file !== []) {
                return $this->initClients($file);
            }
            throw new ClientException(
                'Format error: ' . $this->getFilename(),
                \ALI_INVALID_CREDENTIAL
            );
        } catch (\Exception $e) {
            throw new ClientException($e->getMessage(), \ALI_INVALID_CREDENTIAL, $e);
        }
    }

    /**
     * Initialize clients.
     *
     * @param array $file
     *
     * @return array|mixed
     * @throws ClientException
     */
    private function initClients($file)
    {
        foreach (\array_change_key_case($file) as $clientName => $configures) {
            $configures     = \array_change_key_case($configures);
            $clientInstance = $this->createClient($clientName, $configures);
            if ($clientInstance instanceof Client) {
                self::$hasLoaded[$this->filename][$clientName] = $clientInstance;
                self::setClientAttributes($configures, $clientInstance);
                self::setCert($configures, $clientInstance);
                self::setProxy($configures, $clientInstance);
            }
        }

        return isset(self::$hasLoaded[$this->filename])
            ? self::$hasLoaded[$this->filename]
            : [];
    }
}
