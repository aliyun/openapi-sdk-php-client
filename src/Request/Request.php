<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Filter;
use AlibabaCloud\Client\Http\GuzzleTrait;
use AlibabaCloud\Client\Request\Traits\AcsTrait;
use AlibabaCloud\Client\Request\Traits\ClientTrait;
use AlibabaCloud\Client\Request\Traits\DeprecatedTrait;
use AlibabaCloud\Client\Request\Traits\MagicTrait;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Client\Traits\ArrayAccessTrait;
use AlibabaCloud\Client\Traits\ObjectAccessTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;

/**
 * Class Request
 *
 * @package   AlibabaCloud\Client\Request
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
    use ObjectAccessTrait;

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
    public $client;

    /**
     * @var Uri
     */
    public $uri;

    /**
     * @var Client
     */
    public $guzzle;

    /**
     * @var array The original parameters of the request.
     */
    public $data = [];

    /**
     * @var string
     */
    protected $stringToBeSigned = '';

    /**
     * @var array
     */
    private $userAgent = [];

    /**
     * Request constructor.
     *
     * @param array $options
     *
     * @throws ClientException
     */
    public function __construct(array $options = [])
    {
        $this->client                     = CredentialsProvider::getDefaultName();
        $this->uri                        = new Uri();
        $this->uri                        = $this->uri->withScheme($this->scheme);
        $this->guzzle                     = new Client();
        $this->options['http_errors']     = false;
        $this->options['timeout']         = ALIBABA_CLOUD_TIMEOUT;
        $this->options['connect_timeout'] = ALIBABA_CLOUD_CONNECT_TIMEOUT;
        if ($options !== []) {
            $this->options($options);
        }

        if (strtolower(\AlibabaCloud\Client\env('DEBUG')) === 'sdk') {
            $this->options['debug'] = true;
        }
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     * @throws ClientException
     */
    public function appendUserAgent($name, $value)
    {
        Filter::name($name);

        Filter::value($value);

        if (!UserAgent::isGuarded($name)) {
            $this->userAgent[$name] = $value;
        }

        return $this;
    }

    /**
     * @param array $userAgent
     *
     * @return $this
     */
    public function withUserAgent(array $userAgent)
    {
        $this->userAgent = UserAgent::clean($userAgent);

        return $this;
    }

    /**
     * Set the response data format.
     *
     * @param string $format
     *
     * @return $this
     * @throws ClientException
     */
    public function format($format)
    {
        Filter::format($format);

        $this->format = \strtoupper($format);

        return $this;
    }

    /**
     * Set the request body.
     *
     * @param string $body
     *
     * @return $this
     * @throws ClientException
     */
    public function body($body)
    {
        Filter::body($body);

        $this->options['body'] = $body;

        return $this;
    }

    /**
     * Set the json as body.
     *
     * @param array|object $content
     *
     * @return $this
     * @throws ClientException
     */
    public function jsonBody($content)
    {
        if (!\is_array($content) && !\is_object($content)) {
            throw new ClientException(
                'jsonBody only accepts an array or object',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $this->body(\json_encode($content));
    }

    /**
     * Set the request scheme.
     *
     * @param string $scheme
     *
     * @return $this
     * @throws ClientException
     */
    public function scheme($scheme)
    {
        Filter::scheme($scheme);

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
     * @throws ClientException
     */
    public function host($host)
    {
        Filter::host($host);

        $this->uri = $this->uri->withHost($host);

        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     * @throws ClientException
     */
    public function method($method)
    {
        $this->method = Filter::method($method);

        return $this;
    }

    /**
     * @param string $clientName
     *
     * @return $this
     * @throws ClientException
     */
    public function client($clientName)
    {
        Filter::clientName($clientName);

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
        $this->removeRedundantParameters();

        $this->options['headers']['User-Agent'] = UserAgent::toString($this->userAgent);

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
     * Remove redundant parameters
     *
     * @codeCoverageIgnore
     */
    private function removeRedundantParameters()
    {
        if (isset($this->options['query']) && $this->options['query'] === []) {
            unset($this->options['query']);
        }

        if (isset($this->options['headers']) && $this->options['headers'] === []) {
            unset($this->options['headers']);
        }

        if (isset($this->options['form_params']) && $this->options['form_params'] === []) {
            unset($this->options['form_params']);
        }
    }

    /**
     * @param array $post
     *
     * @return bool|string
     */
    public static function getPostHttpBody(array $post)
    {
        $content = '';
        foreach ($post as $apiKey => $apiValue) {
            $content .= "$apiKey=" . urlencode($apiValue) . '&';
        }

        return substr($content, 0, -1);
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
                \ALIBABA_CLOUD_SERVER_UNREACHABLE,
                $e
            );
        }
    }

    /**
     * @return string
     */
    public function stringToBeSigned()
    {
        return $this->stringToBeSigned;
    }
}
