<?php

namespace AlibabaCloud\Client\Config;

use clagiordano\weblibs\configmanager\ConfigManager;

/**
 * Class Config
 *
 * @package   AlibabaCloud\Client\Config
 */
class Config
{

    /**
     * @var ConfigManager|null
     */
    private static $configManager;

    /**
     * @param string      $configPath
     *
     * @param string|null $defaultValue
     *
     * @return mixed
     */
    public static function get($configPath, $defaultValue = null)
    {
        return self::getConfigManager()
                   ->getValue(
                       \strtolower($configPath),
                       $defaultValue
                   );
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
