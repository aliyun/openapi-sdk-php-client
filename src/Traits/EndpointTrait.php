<?php

namespace AlibabaCloud\Client\Traits;

use InvalidArgumentException;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Config\Config;
use AlibabaCloud\Client\Request\Request;
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
     * @var array user customized EndpointData
     */
    private static $hostsByUserConfig = [];

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

        self::addHostByUserConfig($product, $regionId, $host);

        self::$hosts[$product][$regionId] = $host;

        LocationService::addHost($product, $host, $regionId);
    }

    /**
     * Add user customized host.
     *
     * @param string $product
     * @param string $regionId
     * @param string $host
     */
    private static function addHostByUserConfig($product, $regionId, $host)
    {
        if (empty($product) || empty($regionId) || empty($host)) {
            return;
        }
        $key = self::hostUserConfigKey($product, $regionId);
        if (false === $key) {
            return;
        }

        self::$hostsByUserConfig[$key] = $host;
    }

    /**
     * @param string $product
     * @param string $regionId
     *
     * @return string
     */
    public static function resolveHostByUserConfig($product, $regionId)
    {
        $key = self::hostUserConfigKey($product, $regionId);
        if (false === $key) {
            return "";
        }
        return isset(self::$hostsByUserConfig[$key]) ? self::$hostsByUserConfig[$key] : "";
    }

    /**
     * @param Request $request
     *
     * @return string
     * @throws ClientException
     */
    public static function resolveHostByRule(Request $request)
    {
        $regionId = $request->realRegionId();
        $network  = $request->network ?: 'public';
        $suffix   = $request->endpointSuffix;
        if ($network === 'public') {
            $network = '';
        }

        if ($request->endpointRegional === 'regional') {
            return "{$request->product}{$suffix}{$network}.{$regionId}.aliyuncs.com";
        }

        if ($request->endpointRegional === 'central') {
            return "{$request->product}{$suffix}{$network}.aliyuncs.com";
        }

        throw new InvalidArgumentException('endpointRegional is invalid.');
    }

    /**
     * @param string $product
     * @param string $regionId
     *
     * @return string
     */
    private static function hostUserConfigKey($product, $regionId)
    {
        if (empty($product) || empty($regionId)) {
            return false;
        }
        return $product . "_" . $regionId;
    }
}
