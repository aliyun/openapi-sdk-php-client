<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Regions\EndpointProvider;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\Request;

/**
 * Trait AcsTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/aliyun-openapi-php-sdk
 *
 * @mixin Request
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
    public $locationServiceCode;
    /**
     * @var string
     */
    public $locationEndpointType;

    /**
     * @param string $action
     *
     * @return Request
     */
    public function action($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @param string $version
     *
     * @return Request
     */
    public function version($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @param string $product
     *
     * @return Request
     */
    public function product($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @param string $locationEndpointType
     *
     * @return Request
     */
    public function locationEndpointType($locationEndpointType)
    {
        $this->locationEndpointType = $locationEndpointType;
        return $this;
    }

    /**
     * @param string $locationServiceCode
     *
     * @return Request
     */
    public function locationServiceCode($locationServiceCode)
    {
        $this->locationServiceCode = $locationServiceCode;
        return $this;
    }

    /**
     * @return string
     */
    private function userAgent()
    {
        $array = [
            'alibabacloud' => null,
            'sdk-php'      => \ALIBABA_CLOUD_SDK_VERSION,
            \PHP_OS        => php_uname('r'),
            'PHP'          => \PHP_VERSION,
            'zend_version' => zend_version(),
            'GuzzleHttp'   => \GuzzleHttp\Client::VERSION,
            'curl_version' => \curl_version()['version'],
        ];

        $new = [];
        foreach ($array as $key => $value) {
            if ($value === null) {
                $new[] = $key;
                continue;
            }
            $new[] = $key . '=' . $value;
        }
        return \implode(';', $new);
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
        throw new ClientException("Missing required 'RegionId' for Request", \ALI_INVALID_REGION_ID);
    }

    /**
     * Resolve Uri.
     *
     * @throws ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function resolveUri()
    {
        if ($this->uri->getHost() === 'localhost') {
            // Get the host by specified `ServiceCode` and `RegionId`.
            $host = EndpointProvider::findProductDomain(
                $this->realRegionId(),
                $this->product
            );
            if (!$host && $this->locationServiceCode) {
                $host = LocationService::findProductDomain($this);
            }
            if ($host) {
                $this->uri = $this->uri->withHost($host);
            }
        }
    }
}
