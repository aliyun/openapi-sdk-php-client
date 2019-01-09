<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\Request;
use GuzzleHttp\Client;

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
     * @var array User Agent.
     */
    private $userAgent = [];

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
     */
    private function userAgentString()
    {
        $this->userAgent('alibabacloud', null);
        $this->userAgent('client-php', AlibabaCloud::VERSION);
        $this->userAgent('PHP', \PHP_VERSION);
        $this->userAgent(\PHP_OS, php_uname('r'));
        $this->userAgent('zend_version', zend_version());
        $this->userAgent('GuzzleHttp', Client::VERSION);
        $this->userAgent(
            'curl_version',
            isset(\curl_version()['version'])
                ? \curl_version()['version']
                : ''
        );

        $newUserAgent = [];
        foreach ($this->userAgent as $key => $value) {
            if ($value === null) {
                $newUserAgent[] = $key;
                continue;
            }
            $newUserAgent[] = $key . '=' . $value;
        }
        return \implode(';', $newUserAgent);
    }

    /**
     * set User Agent of Alibaba Cloud.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function userAgent($name, $value)
    {
        $this->userAgent[$name] = $value;

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
        if (AlibabaCloud::getGlobalRegionId() !== null) {
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
