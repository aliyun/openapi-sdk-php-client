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
     * @return string
     * @throws ClientException
     * @throws ServerException
     */
    public static function resolveHost(Request $request, $domain = 'location.aliyuncs.com')
    {
        $instance = new static($request);
        $product  = $instance->request->product;
        $regionId = $instance->request->realRegionId();
        if (!isset(self::$hosts[$product][$regionId])) {
            $locationRequest = new LocationServiceRequest($instance->request, $domain);

            try {
                $result = $locationRequest->request();
            } catch (ServerException $exception) {
                if ($exception->getErrorCode() === 'Illegal Parameter') {
                    return '';
                }
                throw  $exception;
            }

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

            self::$hosts[$product][$regionId] = $result['Endpoints']['Endpoint'][0]['Endpoint'];
            // @codeCoverageIgnoreEnd
        }

        return self::$hosts[$product][$regionId];
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
        self::addHost($product, $domain, $regionId);
    }

    /**
     * @param string $product
     * @param string $host
     * @param string $regionId
     */
    public static function addHost($product, $host, $regionId = \ALIBABA_CLOUD_GLOBAL_REGION)
    {
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
}
