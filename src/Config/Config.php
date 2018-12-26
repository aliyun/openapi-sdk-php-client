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

namespace AlibabaCloud\Client\Config;

use clagiordano\weblibs\configmanager\ConfigManager;

/**
 * Class Config
 *
 * @package   AlibabaCloud\Client\Config
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/aliyun-openapi-php-sdk
 */
class Config
{

    /**
     * @var ConfigManager|null
     */
    private static $configManager;

    /**
     * @param string $configPath
     *
     * @return mixed
     */
    public static function get($configPath)
    {
        return self::getConfigManager()->getValue(\strtolower($configPath));
    }

    /**
     * @param string $configPath
     * @param mixed  $newValue
     *
     * @return ConfigManager
     */
    public static function set($configPath, $newValue)
    {
        self::getConfigManager()->setValue(\strtolower($configPath), $newValue);
        return self::getConfigManager()->saveConfigFile();
    }

    /**
     * @return ConfigManager
     */
    private static function getConfigManager()
    {
        if (!self::$configManager instanceof ConfigManager) {
            self::$configManager = new ConfigManager(__DIR__ . '/Data.php');
        }
        return self::$configManager;
    }
}
