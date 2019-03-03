<?php

namespace AlibabaCloud\Client\Regions;

use AlibabaCloud\Client\Config\Config;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;
use Exception;

/**
 * Class LocationService
 *
 * @package   AlibabaCloud\Client\Regions
 */
class LocationService
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected static $hosts = [];

    /**
     * LocationService constructor.
     *
     * @param Request $request
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @deprecated deprecated since version 2.0, Use resolveHost() instead.
     *
     * @param Request $request
     * @param string  $domain
     *
     * @return mixed
     * @throws ClientException
     */
    public static function findProductDomain(Request $request, $domain = 'location.aliyuncs.com')
    {
        return self::resolveHost($request, $domain);
    }

    /**
     * @param Request $request
     * @param string  $domain
     *
     * @return string
     * @throws ClientException
     */
    public static function resolveHost(Request $request, $domain = 'location.aliyuncs.com')
    {
        $instance = new static($request);
        $product  = $instance->request->product;
        $regionId = $instance->request->realRegionId();

        if (!isset(self::$hosts[$product][$regionId])) {
            self::$hosts[$product][$regionId] = self::getResult($instance, $domain);
        }

        return self::$hosts[$product][$regionId];
    }

    /**
     * @param static $instance
     * @param string $domain
     *
     * @return string
     * @throws ClientException
     */
    private static function getResult($instance, $domain)
    {
        $locationRequest = new LocationServiceRequest($instance->request, $domain);

        try {
            $result = $locationRequest->request();
        } catch (ServerException $exception) {
            return '';
        }

        // @codeCoverageIgnoreStart
        if (!isset($result['Endpoints']['Endpoint'][0]['Endpoint'])) {
            throw new ClientException(
                'Not found RegionId in ' . $domain,
                \ALIBABA_CLOUD_INVALID_REGION_ID
            );
        }

        if (!$result['Endpoints']['Endpoint'][0]['Endpoint']) {
            throw new ClientException(
                'Invalid RegionId: ' . $result['Endpoints']['Endpoint'][0]['Endpoint'],
                \ALIBABA_CLOUD_INVALID_REGION_ID
            );
        }

        return $result['Endpoints']['Endpoint'][0]['Endpoint'];
        // @codeCoverageIgnoreEnd
    }

    /**
     * @deprecated deprecated since version 2.0, Use addHost() instead.
     *
     * @param string $regionId
     * @param string $product
     * @param string $domain
     *
     * @throws ClientException
     */
    public static function addEndPoint($regionId, $product, $domain)
    {
        self::addHost($product, $domain, $regionId);
    }

    /**
     * @param string $product
     * @param string $host
     * @param string $regionId
     *
     * @throws ClientException
     */
    public static function addHost($product, $host, $regionId = \ALIBABA_CLOUD_GLOBAL_REGION)
    {
        if (!$product) {
            throw new ClientException(
                'The argument $product cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if (!$host) {
            throw new ClientException(
                'The argument $host cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if (!$regionId) {
            throw new ClientException(
                'The argument $regionId cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        self::$hosts[$product][$regionId] = $host;
    }

    /**
     * @codeCoverageIgnore
     *
     * @deprecated deprecated since version 2.0.
     *
     * @return void
     */
    public static function modifyServiceDomain()
    {
    }

    /**
     * Update endpoints from OSS.
     *
     * @codeCoverageIgnore
     * @throws Exception
     */
    public static function updateEndpoints()
    {
        $ossUrl = 'https://openapi-endpoints.oss-cn-hangzhou.aliyuncs.com/endpoints.json';
        $json   = \file_get_contents($ossUrl);
        $list   = \json_decode($json, true);

        foreach ($list['endpoints'] as $endpoint) {
            Config::set(
                "endpoints.{$endpoint['service']}.{$endpoint['regionid']}",
                \strtolower($endpoint['endpoint'])
            );
        }
    }
}
