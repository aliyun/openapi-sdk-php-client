<?php

namespace AlibabaCloud\Client\Regions;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;

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
    private static $cache = [];

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
     * @throws ServerException
     */
    public static function findProductDomain(Request $request, $domain = 'location.aliyuncs.com')
    {
        return self::resolveHost($request, $domain);
    }

    /**
     * @param Request $request
     * @param string  $domain
     *
     * @return mixed
     * @throws ClientException
     * @throws ServerException
     */
    public static function resolveHost(Request $request, $domain = 'location.aliyuncs.com')
    {
        $instance = new static($request);
        $key      = $instance->request->realRegionId() . '#' . $instance->request->product;
        if (!isset(self::$cache[$key])) {
            $result = (new LocationServiceRequest($instance->request, $domain))->request();

            // @codeCoverageIgnoreStart
            if (!isset($result['Endpoints']['Endpoint'][0]['Endpoint'])) {
                throw new ClientException(
                    'Can Not Find RegionId From: ' . $domain,
                    \ALIBABA_CLOUD_INVALID_REGION_ID
                );
            }

            if (!$result['Endpoints']['Endpoint'][0]['Endpoint']) {
                throw new ClientException(
                    'Invalid RegionId: ' . $result['Endpoints']['Endpoint'][0]['Endpoint'],
                    \ALIBABA_CLOUD_INVALID_REGION_ID
                );
            }

            self::$cache[$key] = $result['Endpoints']['Endpoint'][0]['Endpoint'];
            // @codeCoverageIgnoreEnd
        }

        return self::$cache[$key];
    }

    /**
     * @deprecated deprecated since version 2.0, Use addHost() instead.
     *
     * @param string $regionId
     * @param string $product
     * @param string $domain
     */
    public static function addEndPoint($regionId, $product, $domain)
    {
        self::addHost($regionId, $product, $domain);
    }

    /**
     * @param string $regionId
     * @param string $product
     * @param string $domain
     */
    public static function addHost($regionId, $product, $domain)
    {
        $key               = $regionId . '#' . $product;
        self::$cache[$key] = $domain;
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
}
