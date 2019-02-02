<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\AlibabaCloud;
use GuzzleHttp\Client;

/**
 * Class UserAgent
 *
 * @package AlibabaCloud\Client\Request
 */
class UserAgent
{

    /**
     * @var array
     */
    private static $userAgent = [];

    /**
     * @return string
     */
    public function __toString()
    {
        $os           = \PHP_OS;
        $os_version   = php_uname('r');
        $os_mode      = php_uname('m');
        $userAgent    = "AlibabaCloud ($os $os_version; $os_mode)";
        $userAgent    .= ' PHP/' . \PHP_VERSION;
        $userAgent    .= ' Client/' . AlibabaCloud::VERSION;
        $userAgent    .= ' Zend/' . zend_version();
        $userAgent    .= ' Guzzle/' . Client::VERSION;
        $curl_version = isset(\curl_version()['version'])
            ? \curl_version()['version']
            : '';
        $userAgent    .= ' CURL/' . $curl_version;
        $userAgent    .= ' ';

        $newUserAgent = [];
        foreach (self::$userAgent as $key => $value) {
            if ($value === null) {
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
     *
     * @return $this
     */
    public function append($name, $value)
    {
        self::$userAgent[$name] = $value;

        return $this;
    }
}
