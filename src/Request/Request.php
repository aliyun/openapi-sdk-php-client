<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Filter\ApiFilter;
use AlibabaCloud\Client\Filter\ClientFilter;
use AlibabaCloud\Client\Filter\Filter;
use AlibabaCloud\Client\Filter\HttpFilter;
use AlibabaCloud\Client\Log\LogFormatter;
use AlibabaCloud\Client\Request\Traits\AcsTrait;
use AlibabaCloud\Client\Request\Traits\ClientTrait;
use AlibabaCloud\Client\Request\Traits\DeprecatedTrait;
use AlibabaCloud\Client\Request\Traits\MagicTrait;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Client\SDK;
use AlibabaCloud\Client\Traits\ArrayAccessTrait;
use AlibabaCloud\Client\Traits\HttpTrait;
use AlibabaCloud\Client\Traits\ObjectAccessTrait;
use AlibabaCloud\Client\Traits\RegionTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
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
    use HttpTrait;
    use RegionTrait;
    use MagicTrait;
    use ClientTrait;
    use AcsTrait;
    use ArrayAccessTrait;
    use ObjectAccessTrait;

    /**
     * Request Connect Timeout
     */
    const CONNECT_TIMEOUT = 5;

    /**
     * Request Timeout
     */
    const TIMEOUT = 10;

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
        $this->options['http_errors']     = false;
        $this->options['connect_timeout'] = self::CONNECT_TIMEOUT;
        $this->options['timeout']         = self::TIMEOUT;
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
        ApiFilter::format($format);

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
        HttpFilter::body($body);

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
                SDK::INVALID_ARGUMENT
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
        HttpFilter::scheme($scheme);

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
        HttpFilter::host($host);

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
        $this->method = HttpFilter::method($method);

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
        ClientFilter::clientName($clientName);

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
        $this->options['headers']['User-Agent'] = UserAgent::toString($this->userAgent);

        $this->removeRedundantQuery();
        $this->removeRedundantHeaders();
        $this->removeRedundantHFormParams();
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
     * Remove redundant Query
     *
     * @codeCoverageIgnore
     */
    private function removeRedundantQuery()
    {
        if (isset($this->options['query']) && $this->options['query'] === []) {
            unset($this->options['query']);
        }
    }

    /**
     * Remove redundant Headers
     *
     * @codeCoverageIgnore
     */
    private function removeRedundantHeaders()
    {
        if (isset($this->options['headers']) && $this->options['headers'] === []) {
            unset($this->options['headers']);
        }
    }

    /**
     * Remove redundant Headers
     *
     * @codeCoverageIgnore
     */
    private function removeRedundantHFormParams()
    {
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
     * @return Client
     * @throws Exception
     */
    public static function createClient()
    {
        if (AlibabaCloud::hasMock()) {
            $stack = HandlerStack::create(AlibabaCloud::getMock());
        } else {
            $stack = HandlerStack::create();
        }

        if (AlibabaCloud::isRememberHistory()) {
            $stack->push(Middleware::history(AlibabaCloud::referenceHistory()));
        }

        if (AlibabaCloud::getLogger()) {
            $stack->push(Middleware::log(
                AlibabaCloud::getLogger(),
                new LogFormatter(AlibabaCloud::getLogFormat())
            ));
        }

        return new Client([
                              'handler' => $stack,
                          ]);
    }

    /**
     * @throws ClientException
     * @throws Exception
     */
    private function response()
    {
        try {
            return self::createClient()->request(
                $this->method,
                (string)$this->uri,
                $this->options
            );
        } catch (GuzzleException $e) {
            throw new ClientException(
                $e->getMessage(),
                SDK::SERVER_UNREACHABLE,
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
