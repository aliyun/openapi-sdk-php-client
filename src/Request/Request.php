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
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Http\GuzzleTrait;
use AlibabaCloud\Client\Request\Traits\AcsTrait;
use AlibabaCloud\Client\Request\Traits\ClientTrait;
use AlibabaCloud\Client\Request\Traits\DeprecatedTrait;
use AlibabaCloud\Client\Request\Traits\MagicTrait;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;

/**
 * Class Request
 *
 * @package   AlibabaCloud\Client\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @method string resolveParameters($credential)
 */
abstract class Request
{
    use /** @scrutinizer ignore-deprecated */
        DeprecatedTrait;
    use GuzzleTrait;
    use MagicTrait;
    use ClientTrait;
    use AcsTrait;

    /**
     * @var string
     */
    public $method = 'GET';
    /**
     * @var string
     */
    public $format = 'JSON';
    /**
     * @var string
     */
    public $clientName = \ALIBABA_CLOUD_GLOBAL_CLIENT;
    /**
     * @var string
     */
    public $uri;
    /**
     * @var Uri
     */
    public $uriComponents;
    /**
     * @var Client
     */
    public $guzzleClient;

    /**
     * Request constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->uriComponents                    = new Uri();
        $this->uriComponents                    = $this->uriComponents->withScheme('http');
        $this->guzzleClient                     = new Client();
        $this->options['http_errors']           = false;
        $this->options['timeout']               = ALIBABA_CLOUD_TIMEOUT;
        $this->options['connect_timeout']       = ALIBABA_CLOUD_CONNECT_TIMEOUT;
        $this->options['headers']['User-Agent'] = $this->userAgent();
        if ($options !== []) {
            $this->options($options);
        }
    }

    /**
     * Set the response data format.
     *
     * @param string $format
     *
     * @return Request
     */
    public function format($format)
    {
        $this->format = \strtoupper($format);
        return $this;
    }

    /**
     * Set the request body.
     *
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
     * Set the request scheme.
     *
     * @param string $scheme
     *
     * @return $this
     */
    public function scheme($scheme)
    {
        $this->uriComponents = $this->uriComponents->withScheme($scheme);
        return $this;
    }

    /**
     * Set the request host.
     *
     * @param string $host
     *
     * @return Request
     */
    public function host($host)
    {
        $this->uriComponents = $this->uriComponents->withHost($host);
        return $this;
    }

    /**
     * @param string $method
     *
     * @return Request
     */
    public function method($method)
    {
        $this->method = \strtoupper($method);
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

    /**
     * @return Result
     * @throws ClientException
     * @throws ServerException
     */
    public function request()
    {
        try {
            $this->resolveHost();
            $this->resolveParameters($this->credential());
            if (isset($this->options['form_params'])) {
                $this->options['form_params'] = \GuzzleHttp\Psr7\parse_query(
                    self::getPostHttpBody($this->options['form_params'])
                );
            }
            $this->mergeOptionsIntoClient();
            $response = $this->guzzleClient->request($this->method, $this->uri, $this->options);
            $result   = new Result($response, $this);
        } catch (GuzzleException $e) {
            throw new ClientException($e->getMessage(), \ALI_SERVER_UNREACHABLE, $e);
        }

        if (!$result->isSuccess()) {
            throw new ServerException($result);
        }

        return $result;
    }
}
