<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Http\GuzzleTrait;
use AlibabaCloud\Client\Request\Traits\AcsTrait;
use AlibabaCloud\Client\Request\Traits\ArrayAccessTrait;
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
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @method string resolveParameters($credential)
 */
abstract class Request implements \ArrayAccess
{
    use DeprecatedTrait;
    use GuzzleTrait;
    use MagicTrait;
    use ClientTrait;
    use AcsTrait;
    use ArrayAccessTrait;

    /**
     * @var string
     */
    public $scheme = 'http';
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
    public $client = \ALIBABA_CLOUD_GLOBAL_CLIENT;
    /**
     * @var Uri
     */
    public $uri;
    /**
     * @var Client
     */
    public $guzzle;
    /**
     * @var array The original parameters of the request object.
     */
    public $parameters = [];

    /**
     * Request constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->uri                              = new Uri();
        $this->uri                              = $this->uri->withScheme($this->scheme);
        $this->guzzle                           = new Client();
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
     * @return $this
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
     * Set the json as body.
     *
     * @param array|object $content
     *
     * @return $this
     */
    public function jsonBody($content)
    {
        if (\is_array($content) || \is_object($content)) {
            $content = \json_encode($content);
        }
        return $this->body($content);
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
        $this->scheme = \strtolower($scheme);
        $this->uri    = $this->uri->withScheme($this->scheme);
        return $this;
    }

    /**
     * Set the request host.
     *
     * @param string $host
     *
     * @return $this
     */
    public function host($host)
    {
        $this->uri = $this->uri->withHost($host);
        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function method($method)
    {
        $this->method = \strtoupper($method);
        return $this;
    }

    /**
     * @param string $clientName
     *
     * @return $this
     */
    public function client($clientName)
    {
        $this->client = $clientName;
        return $this;
    }

    /**
     * @return bool
     * @throws ClientException
     */
    public function isDebug()
    {
        if (isset($this->options['debug'])) {
            return $this->options['debug'] === true;
        }

        if (isset($this->httpClient()->options['debug'])) {
            return $this->httpClient()->options['debug'] === true;
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
        $this->resolveUri();

        $this->resolveParameters($this->credential());

        if (isset($this->options['form_params'])) {
            $this->options['form_params'] = \GuzzleHttp\Psr7\parse_query(
                self::getPostHttpBody($this->options['form_params'])
            );
        }

        $this->mergeOptionsIntoClient();

        $result = new Result($this->response(), $this);

        if (!$result->isSuccess()) {
            throw new ServerException($result);
        }

        return $result;
    }

    /**
     * @throws ClientException
     */
    private function response()
    {
        try {
            return $this->guzzle->request(
                $this->method,
                (string)$this->uri,
                $this->options
            );
        } catch (GuzzleException $e) {
            throw new ClientException(
                $e->getMessage(),
                \ALI_SERVER_UNREACHABLE,
                $e
            );
        }
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->parameters[$name])
            ? $this->parameters[$name]
            : null;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->parameters[$name]);
    }

    /**
     * @param $name
     *
     * @return void
     */
    public function __unset($name)
    {
        unset($this->parameters[$name]);
    }
}
