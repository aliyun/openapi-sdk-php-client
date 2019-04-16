<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\SDK;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Filter\ApiFilter;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

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
        ApiFilter::action($action);

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
        ApiFilter::version($version);

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
        ApiFilter::product($product);

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
        ApiFilter::endpointType($endpointType);

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
        ApiFilter::serviceCode($serviceCode);

        $this->serviceCode = $serviceCode;

        return $this;
    }

    /**
     * Resolve Host.
     *
     * @throws ClientException
     * @throws ServerException
     */
    public function resolveHost()
    {
        if ($this->uri->getHost() === 'localhost') {
            $regionId = $this->realRegionId();

            // 1. Find in the local array file
            $host = AlibabaCloud::resolveHost(
                $this->product,
                $regionId
            );

            // 2. Find in the Location service
            if (!$host && $this->serviceCode) {
                $host = LocationService::resolveHost($this);
            }

            if (!$host) {
                throw new ClientException(
                    "No host found for {$this->product} in the {$regionId}, you can specify host by host() method.",
                    SDK::HOST_NOT_FOUND
                );
            }

            $this->uri = $this->uri->withHost($host);
        }
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

        throw new ClientException("Missing required 'RegionId' for Request", SDK::INVALID_REGION_ID);
    }
}
