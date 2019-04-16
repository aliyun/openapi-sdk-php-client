<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Config\Config;
use AlibabaCloud\Client\Filter\ApiFilter;
use AlibabaCloud\Client\Filter\HttpFilter;
use AlibabaCloud\Client\Filter\ClientFilter;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Exception\ClientException;

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
     * Resolve host based on product name and region.
     *
     * @param string $product
     * @param string $regionId
     *
     * @return string
     * @throws ClientException
     */
    public static function resolveHost($product, $regionId = LocationService::GLOBAL_REGION)
    {
        ApiFilter::product($product);
        ClientFilter::regionId($regionId);

        if (isset(self::$hosts[$product][$regionId])) {
            return self::$hosts[$product][$regionId];
        }

        $domain = Config::get("endpoints.{$product}.{$regionId}");
        if (!$domain) {
            $regionId = LocationService::GLOBAL_REGION;
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
     * @throws ClientException
     */
    public static function addHost($product, $host, $regionId = LocationService::GLOBAL_REGION)
    {
        ApiFilter::product($product);

        HttpFilter::host($host);

        ClientFilter::regionId($regionId);

        self::$hosts[$product][$regionId] = $host;

        LocationService::addHost($product, $host, $regionId);
    }
}
