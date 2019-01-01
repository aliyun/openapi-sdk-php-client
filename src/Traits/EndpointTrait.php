<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Config\Config;
use AlibabaCloud\Client\Regions\LocationService;

/**
 * Help developers set up and get host.
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
     * @var array Host cache.
     */
    private static $hosts = [];

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
     * Resolve host based on product name and region.
     *
     * @param string $regionId
     * @param string $product
     *
     * @return string
     */
    public static function resolveHost($regionId, $product)
    {
        if (isset(self::$hosts[$product][$regionId])) {
            return self::$hosts[$product][$regionId];
        }
        $domain = Config::get("endpoints.{$product}.{$regionId}");
        if ($domain) {
            return $domain;
        }
        return '';
    }

    /**
     * Add host based on product name and region.
     *
     * @param string $regionId
     * @param string $product
     * @param string $domain
     *
     * @return void
     */
    public static function addHost($regionId, $product, $domain)
    {
        self::$hosts[$product][$regionId] = $domain;
        LocationService::addHost($regionId, $product, $domain);
    }
}
