<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\AlibabaCloud;
use GuzzleHttp\Client;

/**
 * Class UserAgent.
 */
class UserAgent
{
    /**
     * @var array
     */
    private static $userAgent = [];

    /**
     * @var array
     */
    private static $guard = [
        'php',
        'client',
        'zend',
        'guzzle',
        'curl',
    ];

    /**
     * @return string
     */
    public static function toString()
    {
        self::defaultFields();

        $os         = \PHP_OS;
        $os_version = php_uname('r');
        $os_mode    = php_uname('m');
        $userAgent  = "AlibabaCloud ($os $os_version; $os_mode) ";

        $newUserAgent = [];
        foreach (self::$userAgent as $key => $value) {
            if (null === $value) {
                $newUserAgent[] = $key;
                continue;
            }
            $newUserAgent[] = $key . '/' . $value;
        }

        return $userAgent . \implode(' ', $newUserAgent);
    }

    /**
     * set User Agent of Alibaba Cloud.
     *
     * @param string $name
     * @param string $value
     */
    public static function append($name, $value)
    {
        self::defaultFields();

        if (!self::isGuarded($name)) {
            self::$userAgent[$name] = $value;
        }
    }

    /**
     * UserAgent constructor.
     */
    private static function defaultFields()
    {
        if (self::$userAgent === []) {
            self::$userAgent = [
                'PHP'    => \PHP_VERSION,
                'Client' => AlibabaCloud::VERSION,
                'Zend'   => zend_version(),
                'Guzzle' => Client::VERSION,
                'CURL'   => isset(\curl_version()['version'])
                    ? \curl_version()['version']
                    : 'none',
            ];
        }
    }

    /**
     * @param $name
     *
     * @return bool
     */
    private static function isGuarded($name)
    {
        return in_array(strtolower($name), self::$guard, true);
    }
}
