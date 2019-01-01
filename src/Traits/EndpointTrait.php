<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Config\Config;
use AlibabaCloud\Client\Regions\LocationService;

/**
 * Trait EndpointTrait
 *
 * @package   AlibabaCloud\Client\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin     AlibabaCloud
 */
trait EndpointTrait
{
    /**
     * @var array
     */
    private static $endpoints = [];

    /**
     * @deprecated
     *
     * @param string $regionId
     * @param string $product
     *
     * @return string
     */
    public static function findProductDomain($regionId, $product)
    {
        return self::resolveHost($regionId, $product);
    }

    /**
     * @deprecated
     *
     * @param string $regionId
     * @param string $product
     * @param string $domain
     *
     * @return void
     */
    public static function addEndpoint($regionId, $product, $domain)
    {
        self::addHost($regionId, $product, $domain);
    }

    /**
     * @param string $regionId
     * @param string $product
     *
     * @return string
     */
    public static function resolveHost($regionId, $product)
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
    public static function addHost($regionId, $product, $domain)
    {
        self::$endpoints[$product][$regionId] = $domain;
        LocationService::addHost($regionId, $product, $domain);
    }
}
