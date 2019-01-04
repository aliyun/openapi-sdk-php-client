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
 * @mixin     AlibabaCloud
 */
trait EndpointTrait
{
    /**
     * @var array Host cache.
     */
    private static $hosts = [];

    /**
     * @deprecated deprecated since version 2.0, Use resolveHost() instead.
     *
     * @param string $regionId
     * @param string $product
     *
     * @return string
     */
    public static function findProductDomain($regionId, $product)
    {
        return self::resolveHost($product, $regionId);
    }

    /**
     * @deprecated deprecated since version 2.0, Use addHost() instead.
     *
     * @param string $regionId
     * @param string $product
     * @param string $domain
     *
     * @return void
     */
    public static function addEndpoint($regionId, $product, $domain)
    {
        self::addHost($product, $domain, $regionId);
    }

    /**
     * Resolve host based on product name and region.
     *
     * @param string $product
     * @param string $regionId
     *
     * @return string
     */
    public static function resolveHost($product, $regionId = \ALIBABA_CLOUD_GLOBAL_REGION)
    {
        if (isset(self::$hosts[$product][$regionId])) {
            return self::$hosts[$product][$regionId];
        }

        $domain = Config::get("endpoints.{$product}.{$regionId}");
        if (!$domain) {
            $regionId = \ALIBABA_CLOUD_GLOBAL_REGION;
            $domain   = Config::get("endpoints.{$product}.{$regionId}", '');
        }

        return $domain;
    }

    /**
     * Add host based on product name and region.
     *
     * @param string $product
     * @param string $host
     * @param string $regionId
     *
     * @return void
     */
    public static function addHost($product, $host, $regionId = \ALIBABA_CLOUD_GLOBAL_REGION)
    {
        self::$hosts[$product][$regionId] = $host;
        LocationService::addHost($product, $host, $regionId);
    }
}
