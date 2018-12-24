<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Http\GuzzleTrait;
use AlibabaCloud\Client\Regions\EndpointProvider;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\Traits\ClientTrait;
use AlibabaCloud\Client\Request\Traits\DeprecatedTrait;
use AlibabaCloud\Client\Request\Traits\MagicTrait;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Request
 *
 * @package AlibabaCloud\Client\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 *
 * @method string preparationParameters($credential)
 */
abstract class Request
{
    use DeprecatedTrait;
    use GuzzleTrait;
    use MagicTrait;
    use ClientTrait;

    /**
     * @var string
     */
    public $method = 'GET';
    /**
     * @var string
     */
    public $clientName = \ALIBABA_CLOUD_GLOBAL_CLIENT;
    /**
     * @var string
     */
    public $domain;
    /**
     * @var string
     */
    public $protocol = 'http';
    /**
     * @var string
     */
    public $uri;
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
    public $format;
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
     * @param string $format
     *
     * @return Request
     */
    public function format($format)
    {
        $this->format = $format;
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
     * @param string $content
     *
     * @return $this
     */
    public function body($content)
    {
        $this->options['body'] = $content;
        return $this;
    }

    /**
     * Request constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options['http_errors']           = false;
        $this->options['timeout']               = ALIBABA_CLOUD_TIMEOUT;
        $this->options['connect_timeout']       = ALIBABA_CLOUD_CONNECT_TIMEOUT;
        $this->options['headers']['User-Agent'] = $this->userAgent();
        if ($options !== []) {
            $this->options($options);
        }
    }

    /**
     * @param string $protocol
     *
     * @return $this
     */
    public function protocol($protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @param string $domain
     *
     * @return Request
     */
    public function domain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @param string $method
     *
     * @return Request
     */
    public function method($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $clientName
     *
     * @return static
     */
    public function client($clientName)
    {
        $this->clientName = $clientName;
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
     * @return Result
     * @throws ClientException
     * @throws ServerException
     */
    public function request()
    {
        try {
            if (!$this->domain) {
                $this->domain = EndpointProvider::findProductDomain(
                    $this->realRegionId(),
                    $this->product
                );
            }

            /**----------------------------------------------------------------
             *   Get the domain by specified `ServiceCode` and `RegionId`.
             *---------------------------------------------------------------*/
            if (!$this->domain && $this->locationServiceCode) {
                $this->domain = LocationService::findProductDomain($this);
            }

            $this->preparationParameters($this->credential());

            if (isset($this->options['form_params'])) {
                $this->options['form_params'] =
                    \GuzzleHttp\Psr7\parse_query(self::getPostHttpBody($this->options['form_params']));
                if (!\is_array($this->options['form_params']) || empty($this->options['form_params'])) {
                    unset($this->options['form_params']);
                }
            }
            $this->mergeOptionsIntoClient();
            $response = (new Client())->request($this->method, $this->uri, $this->options);
            $result   = new Result($response, $this);
        } catch (GuzzleException $e) {
            throw new ClientException($e->getMessage(), \ALI_SERVER_UNREACHABLE, $e);
        }

        if (!$result->isSuccess()) {
            throw new ServerException($result);
        }

        return $result;
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
     * @return bool
     * @throws ClientException
     */
    public function isDebug()
    {
        if (isset($this->options['debug'])) {
            return $this->options['debug'] === true && PHP_SAPI === 'cli';
        }

        if (isset($this->httpClient()->options['debug'])) {
            return $this->httpClient()->options['debug'] === true && PHP_SAPI === 'cli';
        }
        return false;
    }
}
