<?php

namespace AlibabaCloud\Client\Credentials\Ini;

use AlibabaCloud\Client\Clients\Client;

/**
 * Trait OptionsTrait
 *
 * @package   AlibabaCloud\Client\Credentials\Ini
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin IniCredential
 */
trait OptionsTrait
{
    /**
     * @param array  $configures
     * @param Client $client
     */
    private static function setClientAttributes($configures, Client $client)
    {
        if (self::isNotEmpty($configures, 'region_id')) {
            $client->regionId($configures['region_id']);
        }

        if (isset($configures['debug'])) {
            $client->options(
                [
                    'debug' => (bool)$configures['debug'],
                ]
            );
        }

        if (self::isNotEmpty($configures, 'timeout')) {
            $client->options(
                [
                    'timeout' => $configures['timeout'],
                ]
            );
        }

        if (self::isNotEmpty($configures, 'connect_timeout')) {
            $client->options(
                [
                    'connect_timeout' => $configures['connect_timeout'],
                ]
            );
        }
    }

    /**
     * @param array  $configures
     * @param Client $client
     */
    private static function setProxy($configures, Client $client)
    {
        if (self::isNotEmpty($configures, 'proxy')) {
            $client->options(
                [
                    'proxy' => $configures['proxy'],
                ]
            );
        }
        $proxy = [];
        if (self::isNotEmpty($configures, 'proxy_http')) {
            $proxy['http'] = $configures['proxy_http'];
        }
        if (self::isNotEmpty($configures, 'proxy_https')) {
            $proxy['https'] = $configures['proxy_https'];
        }
        if (self::isNotEmpty($configures, 'proxy_no')) {
            $proxy['no'] = \explode(',', $configures['proxy_no']);
        }
        if ($proxy !== []) {
            $client->options(
                [
                    'proxy' => $proxy,
                ]
            );
        }
    }

    /**
     * @param array  $configures
     * @param Client $client
     */
    private static function setCert($configures, Client $client)
    {
        if (self::isNotEmpty($configures, 'cert_file') && !self::isNotEmpty($configures, 'cert_password')) {
            $client->options(
                [
                    'cert' => $configures['cert_file'],
                ]
            );
        }

        if (self::isNotEmpty($configures, 'cert_file') && self::isNotEmpty($configures, 'cert_password')) {
            $client->options(
                [
                    'cert' => [
                        $configures['cert_file'],
                        $configures['cert_password'],
                    ],
                ]
            );
        }
    }
}
