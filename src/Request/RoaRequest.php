<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Request\Traits\DeprecatedRoaTrait;

/**
 * Class RoaRequest
 *
 * @package   AlibabaCloud\Client\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RoaRequest extends Request
{
    use DeprecatedRoaTrait;

    /**
     * @var string
     */
    public $pathPattern;
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
    private static $headerSeparator = \PHP_EOL;
    /**
     * @var string
     */
    private static $querySeparator = '&';

    /**
     * @return string
     */
    private function contentMD5()
    {
        return base64_encode(
            md5(json_encode($this->options['form_params']), true)
        );
    }

    /**
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
     * @param AccessKeyCredential|BearerTokenCredential|StsCredential $credential
     *
     * @throws ClientException
     */
    private function sign($credential)
    {
        $signString = $this->method . self::$headerSeparator;
        if (isset($this->options['headers']['Accept'])) {
            $signString .= $this->options['headers']['Accept'];
        }
        $signString .= self::$headerSeparator;

        if (isset($this->options['headers']['Content-MD5'])) {
            $signString .= $this->options['headers']['Content-MD5'];
        }
        $signString .= self::$headerSeparator;

        if (isset($this->options['headers']['Content-Type'])) {
            $signString .= $this->options['headers']['Content-Type'];
        }
        $signString .= self::$headerSeparator;

        if (isset($this->options['headers']['Date'])) {
            $signString .= $this->options['headers']['Date'];
        }
        $signString .= self::$headerSeparator;

        $signString .= $this->buildCanonicalHeaders();

        $this->uri = $this->uri
            ->withPath($this->assignPathParameters())
            ->withQuery($this->queryString());

        $signString .= $this->uri->getPath() . '?' . $this->uri->getQuery();

        $this->options['headers']['Authorization'] = 'acs '
                                                     . $credential->getAccessKeyId()
                                                     . ':'
                                                     . $this->httpClient()
                                                            ->getSignature()
                                                            ->sign(
                                                                $signString,
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
     * @return string
     */
    private function buildCanonicalHeaders()
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
     * @param string $queryString
     * @param array  $sortMap
     *
     * @return string
     */
    private function ksort(&$queryString, array $sortMap)
    {
        ksort($sortMap);
        foreach ($sortMap as $sortMapKey => $sortMapValue) {
            $queryString .= $sortMapKey;
            if ($sortMapValue !== null) {
                $queryString .= '=' . $sortMapValue;
            }
            $queryString .= self::$querySeparator;
        }
        return $queryString;
    }

    /**
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
        if (\strpos($name, 'get', 0) !== false) {
            $parameterName = $this->propertyNameByMethodName($name);
            return $this->__get($parameterName);
        }

        if (\strpos($name, 'set', 0) !== false) {
            $parameterName = $this->propertyNameByMethodName($name);
            $this->__set($parameterName, $arguments[0]);
            $this->pathParameters[$parameterName] = $arguments[0];
        }

        return $this;
    }
}
