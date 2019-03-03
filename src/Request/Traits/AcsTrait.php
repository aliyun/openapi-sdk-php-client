<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Filter;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\Request;

/**
 * Trait AcsTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
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
     * @throws ClientException
     */
    public function action($action)
    {
        Filter::action($action);

        $this->action = $action;

        return $this;
    }

    /**
     * @param string $version
     *
     * @return $this
     * @throws ClientException
     */
    public function version($version)
    {
        Filter::version($version);

        $this->version = $version;

        return $this;
    }

    /**
     * @param string $product
     *
     * @return $this
     * @throws ClientException
     */
    public function product($product)
    {
        Filter::product($product);

        $this->product = $product;

        return $this;
    }

    /**
     * @param string $endpointType
     *
     * @return $this
     * @throws ClientException
     */
    public function endpointType($endpointType)
    {
        Filter::endpointType($endpointType);

        $this->endpointType = $endpointType;

        return $this;
    }

    /**
     * @param string $serviceCode
     *
     * @return $this
     * @throws ClientException
     */
    public function serviceCode($serviceCode)
    {
        Filter::serviceCode($serviceCode);

        $this->serviceCode = $serviceCode;

        return $this;
    }

    /**
     * @return string
     * @throws ClientException
     */
    public function realRegionId()
    {
        if ($this->regionId !== null) {
            return $this->regionId;
        }

        if ($this->httpClient()->regionId !== null) {
            return $this->httpClient()->regionId;
        }

        if (AlibabaCloud::getDefaultRegionId() !== null) {
            return AlibabaCloud::getDefaultRegionId();
        }

        throw new ClientException("Missing required 'RegionId' for Request", \ALIBABA_CLOUD_INVALID_REGION_ID);
    }

    /**
     * Resolve Uri.
     *
     * @throws ClientException
     */
    public function resolveUri()
    {
        if ($this->uri->getHost() === 'localhost') {
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
