<?php

namespace AlibabaCloud\Client\Regions;

use AlibabaCloud\Client\Config\Config;

/**
 * Class EndpointProvider
 *
 * @package   AlibabaCloud\Client\Regions
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class EndpointProvider
{

    /**
     * @var array
     */
    private static $endpoints = [];

    /**
     * @param string $regionId
     * @param string $product
     *
     * @return string
     */
    public static function findProductDomain($regionId, $product)
    {
        if (isset(self::$endpoints[$product][$regionId])) {
            return self::$endpoints[$product][$regionId];
        }
        $domain = Config::get("endpoints.{$product}.{$regionId}");
        if ($domain) {
            return $domain;
        }
        return '';
    }

    /**
     * @param string $regionId
     * @param string $product
     * @param string $domain
     *
     * @return void
     */
    public static function addEndpoint($regionId, $product, $domain)
    {
        self::$endpoints[$product][$regionId] = $domain;
        LocationService::addEndPoint($regionId, $product, $domain);
    }
}
