<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Request\Traits\DeprecatedRoaTrait;

/**
 * RESTful ROA Request.
 *
 * @package   AlibabaCloud\Client\Request
 */
class RoaRequest extends Request
{
    use DeprecatedRoaTrait;

    /**
     * @var string
     */
    public $pathPattern = '/';

    /**
     * @var array
     */
    public $pathParameters = [];

    /**
     * @var string
     */
    private $dateTimeFormat = "D, d M Y H:i:s \G\M\T";

    /**
     * @var string
     */
    private static $headerSeparator = "\n";

    /**
     * @var string
     */
    private static $querySeparator = '&';

    /**
     * Calculate the md5 value of the content.
     *
     * @return string
     */
    private function contentMD5()
    {
        return base64_encode(
            md5(json_encode($this->options['form_params']), true)
        );
    }

    /**
     * Resolve request parameter.
     *
     * @param AccessKeyCredential|BearerTokenCredential|StsCredential|CredentialsInterface $credential
     *
     * @throws ClientException
     */
    public function resolveParameters($credential)
    {
        $this->options['query']['Version']                   = $this->version;
        $this->options['headers']['x-acs-version']           = $this->version;
        $signature                                           = $this->httpClient()->getSignature();
        $this->options['headers']['Date']                    = gmdate($this->dateTimeFormat);
        $this->options['headers']['Accept']                  = $this->formatToAccept($this->format);
        $this->options['headers']['x-acs-signature-method']  = $signature->getMethod();
        $this->options['headers']['x-acs-signature-version'] = $signature->getVersion();
        if ($signature->getType()) {
            $this->options['headers']['x-acs-signature-type'] = $signature->getType();
        }
        $this->options['headers']['x-acs-region-id'] = $this->realRegionId();
        if (isset($this->options['form_params'])) {
            $this->options['headers']['Content-MD5'] = $this->contentMD5();
        }
        $this->options['headers']['Content-Type'] = "{$this->options['headers']['Accept']};chrset=utf-8";
        if ($credential instanceof StsCredential) {
            $this->options['headers']['x-acs-security-token'] = $credential->getSecurityToken();
        }
        if ($credential instanceof BearerTokenCredential) {
            $this->options['headers']['x-acs-bearer-token'] = $credential->getBearerToken();
        }
        $this->sign($credential);
    }

    /**
     * Sign the request message.
     *
     * @param AccessKeyCredential|BearerTokenCredential|StsCredential $credential
     *
     * @throws ClientException
     */
    private function sign($credential)
    {
        $stringToBeSigned = $this->method . self::$headerSeparator;
        if (isset($this->options['headers']['Accept'])) {
            $stringToBeSigned .= $this->options['headers']['Accept'];
        }
        $stringToBeSigned .= self::$headerSeparator;

        if (isset($this->options['headers']['Content-MD5'])) {
            $stringToBeSigned .= $this->options['headers']['Content-MD5'];
        }
        $stringToBeSigned .= self::$headerSeparator;

        if (isset($this->options['headers']['Content-Type'])) {
            $stringToBeSigned .= $this->options['headers']['Content-Type'];
        }
        $stringToBeSigned .= self::$headerSeparator;

        if (isset($this->options['headers']['Date'])) {
            $stringToBeSigned .= $this->options['headers']['Date'];
        }
        $stringToBeSigned .= self::$headerSeparator;

        $stringToBeSigned .= $this->constructAcsHeader();

        $this->uri = $this->uri->withPath($this->assignPathParameters())
                               ->withQuery($this->queryString());

        $stringToBeSigned .= $this->uri->getPath() . '?' . $this->uri->getQuery();

        $this->stringToBeSigned = $stringToBeSigned;

        $this->options['headers']['Authorization'] = 'acs '
                                                     . $credential->getAccessKeyId()
                                                     . ':'
                                                     . $this->httpClient()
                                                            ->getSignature()
                                                            ->sign(
                                                                $this->stringToBeSigned,
                                                                $credential->getAccessKeySecret()
                                                            );
    }

    /**
     * Assign path parameters to the url.
     *
     * @return string
     */
    private function assignPathParameters()
    {
        $result = $this->pathPattern;
        foreach ($this->pathParameters as $pathParameterKey => $apiParameterValue) {
            $target = '[' . $pathParameterKey . ']';
            $result = str_replace($target, $apiParameterValue, $result);
        }
        return $result;
    }

    /**
     * Construct standard Header for Alibaba Cloud.
     *
     * @return string
     */
    private function constructAcsHeader()
    {
        $sortMap = [];
        foreach ($this->options['headers'] as $headerKey => $headerValue) {
            $key = strtolower($headerKey);
            if (strpos($key, 'x-acs-') === 0) {
                $sortMap[$key] = $headerValue;
            }
        }
        ksort($sortMap);
        $headerString = '';
        foreach ($sortMap as $sortMapKey => $sortMapValue) {
            $headerString .= $sortMapKey . ':' . $sortMapValue . self::$headerSeparator;
        }
        return $headerString;
    }

    /**
     * Get the query string.
     *
     * @return bool|mixed|string
     */
    public function queryString()
    {
        $query = isset($this->options['query'])
            ? $this->options['query']
            : [];

        $queryString = $this->ksort($queryString, $query);

        if (0 < count($query)) {
            $queryString = substr($queryString, 0, -1);
        }

        return $queryString;
    }

    /**
     * Sort the entries by key.
     *
     * @param string $queryString
     * @param array  $map
     *
     * @return string
     */
    private function ksort(&$queryString, array $map)
    {
        ksort($map);
        foreach ($map as $sortMapKey => $sortMapValue) {
            $queryString .= $sortMapKey;
            if ($sortMapValue !== null) {
                $queryString .= '=' . $sortMapValue;
            }
            $queryString .= self::$querySeparator;
        }
        return $queryString;
    }

    /**
     * Returns the accept header according to format.
     *
     * @param string $format
     *
     * @return string
     */
    private function formatToAccept($format)
    {
        switch (\strtoupper($format)) {
            case 'JSON':
                return 'application/json';
            case 'XML':
                return 'application/xml';
            default:
                return 'application/octet-stream';
        }
    }

    /**
     * Set path parameter by name.
     *
     * @param string $name
     * @param string $value
     *
     * @return RoaRequest
     */
    public function pathParameter($name, $value)
    {
        $this->pathParameters[$name] = $value;
        return $this;
    }

    /**
     * Set path pattern.
     *
     * @param string $pattern
     *
     * @return self
     */
    public function pathPattern($pattern)
    {
        $this->pathPattern = $pattern;
        return $this;
    }

    /**
     * Magic method for set or get request parameters.
     *
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (\strpos($name, 'get') !== false) {
            $parameterName = $this->propertyNameByMethodName($name);
            return $this->__get($parameterName);
        }

        if (\strpos($name, 'with') !== false) {
            $parameterName = $this->propertyNameByMethodName($name, 4);
            $this->__set($parameterName, $arguments[0]);
            $this->pathParameters[$parameterName] = $arguments[0];
        }

        return $this;
    }
}
