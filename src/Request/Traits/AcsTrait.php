<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\Request;

/**
 * Trait AcsTrait.
 *
 *
 * @mixin     Request
 */
trait AcsTrait
{
    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $product;

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $serviceCode = '';

    /**
     * @var string
     */
    public $endpointType = 'openAPI';

    /**
     * @param string $action
     *
     * @return $this
     */
    public function action($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param string $version
     *
     * @return $this
     */
    public function version($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param string $product
     *
     * @return $this
     */
    public function product($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @param string $endpointType
     *
     * @return $this
     */
    public function endpointType($endpointType)
    {
        $this->endpointType = $endpointType;

        return $this;
    }

    /**
     * @param string $serviceCode
     *
     * @return $this
     */
    public function serviceCode($serviceCode)
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    /**
     * @return string
     *
     * @throws ClientException
     */
    public function realRegionId()
    {
        if (null !== $this->regionId) {
            return $this->regionId;
        }
        if (null !== $this->httpClient()->regionId) {
            return $this->httpClient()->regionId;
        }
        if (null !== AlibabaCloud::getGlobalRegionId()) {
            return AlibabaCloud::getGlobalRegionId();
        }
        throw new ClientException(
            "Missing required 'RegionId' for Request",
            \ALIBABA_CLOUD_INVALID_REGION_ID
        );
    }

    /**
     * Resolve Uri.
     *
     * @throws ClientException
     */
    public function resolveUri()
    {
        if ('localhost' === $this->uri->getHost()) {
            // Get the host by specified `ServiceCode` and `RegionId`.
            $host = AlibabaCloud::resolveHost(
                $this->product,
                $this->realRegionId()
            );

            if (!$host && $this->serviceCode) {
                $host = LocationService::resolveHost($this);
            }

            if (!$host) {
                throw new ClientException(
                    "Can't resolve host for {$this->product} in "
                    . $this->realRegionId()
                    . ', You can specify host via the host() method.',
                    \ALIBABA_CLOUD_INVALID_REGION_ID
                );
            }

            $this->uri = $this->uri->withHost($host);
        }
    }
}
