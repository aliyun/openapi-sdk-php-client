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

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class RoaRequest
 *
 * @package AlibabaCloud\Client\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */
class RoaRequest extends Request
{

    /**
     * @var string
     */
    public $uriPattern;
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
     * RoaRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->method('RAW');
        $this->format('JSON');
    }

    /**
     * @param AccessKeyCredential|BearerTokenCredential|CredentialsInterface $credential
     *
     * @throws ClientException
     */
    public function preparationParameters($credential)
    {
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
            $this->options['headers']['Content-MD5'] =
                base64_encode(md5(json_encode($this->options['form_params']), true));
        }
        $this->options['headers']['Content-Type'] = 'application/octet-stream;charset=utf-8';
        if ($this->format === 'JSON') {
            $this->options['headers']['Content-Type'] = 'application/json;chrset=utf-8';
        }
        if ($credential instanceof StsCredential) {
            $this->options['headers']['x-acs-security-token'] = $credential->getSecurityToken();
        }
        if ($credential instanceof BearerTokenCredential) {
            $this->options['headers']['x-acs-bearer-token'] = $credential->getBearerToken();
        }
        $this->sign($credential);
    }

    /**
     * @param AccessKeyCredential|BearerTokenCredential|CredentialsInterface $credential
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

        $queryString                               = $this->buildQueryString($this->replaceOccupiedParameters());
        $signString                                .= $queryString;
        $this->options['headers']['Authorization'] = 'acs '
                                                     . $credential->getAccessKeyId()
                                                     . ':'
                                                     . $this->httpClient()
                                                            ->getSignature()
                                                            ->sign(
                                                                $signString,
                                                                $credential->getAccessKeySecret()
                                                            );

        $this->uri = $this->protocol . '://' . $this->domain . $queryString;
    }

    /**
     * @return string
     */
    private function replaceOccupiedParameters()
    {
        $result = $this->uriPattern;
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
            $headerString = $headerString . $sortMapKey . ':' . $sortMapValue . self::$headerSeparator;
        }
        return $headerString;
    }

    /**
     * @param string $uri
     *
     * @return array
     */
    private function splitSubResource($uri)
    {
        $queIndex = strpos($uri, '?');
        $uriParts = [];
        if (false !== $queIndex) {
            $uriParts[] = substr($uri, 0, $queIndex);
            $uriParts[] = substr($uri, $queIndex + 1);
            return $uriParts;
        }

        $uriParts[] = $uri;
        return $uriParts;
    }

    /**
     * @param string $uri
     *
     * @return bool|mixed|string
     */
    private function buildQueryString($uri)
    {
        $uriParts = $this->splitSubResource($uri);
        $sortMap  = $this->options['query'];
        if (isset($uriParts[1])) {
            $sortMap[$uriParts[1]] = null;
        }
        $queryString = $uriParts[0];
        if (count($uriParts)) {
            $queryString .= '?';
        }
        ksort($sortMap);
        foreach ($sortMap as $sortMapKey => $sortMapValue) {
            $queryString .= $sortMapKey;
            if ($sortMapValue !== null) {
                $queryString = $queryString . '=' . $sortMapValue;
            }
            $queryString .= self::$querySeparator;
        }
        if (0 < count($sortMap)) {
            $queryString = substr($queryString, 0, -1);
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
     * @deprecated
     * @codeCoverageIgnore
     * @return array
     */
    public function getPathParameters()
    {
        return $this->pathParameters;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     *
     * @param string $name
     * @param string $value
     *
     * @return RoaRequest
     */
    public function putPathParameter($name, $value)
    {
        return $this->pathParameter($name, $value);
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
     * @codeCoverageIgnore
     * @deprecated
     * @return mixed
     */
    public function getUriPattern()
    {
        return $this->uriPattern;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     *
     * @param string $uriPattern
     *
     * @return self
     */
    public function setUriPattern($uriPattern)
    {
        return $this->uriPattern($uriPattern);
    }

    /**
     * @param string $uriPattern
     *
     * @return self
     */
    public function uriPattern($uriPattern)
    {
        $this->uriPattern = $uriPattern;
        return $this;
    }

    /**
     * @param string $version
     *
     * @return RoaRequest
     */
    public function version($version)
    {
        $this->options['query']['Version']         = $version;
        $this->options['headers']['x-acs-version'] = $version;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (\strpos($name, 'get', 0) !== false) {
            return $this->__get($this->propertyNameByMethodName($name));
        }
        if (\strpos($name, 'set', 0) !== false) {
            $this->__set($this->propertyNameByMethodName($name), $arguments[0]);
        }
        return $this;
    }

    /**
     * When get a property that does not exist, it can be understood as a custom request parameter.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->pathParameters[$name])
            ? $this->pathParameters[$name]
            : null;
    }

    /**
     * When set a property that does not exist, it can be understood as a custom request parameter.
     *
     * @param string       $name
     * @param string|mixed $value
     */
    public function __set($name, $value)
    {
        $this->pathParameters[$name] = $value;
    }

    /**
     * When accessing a property that does not exist, it can be understood as a custom request parameter.
     *
     * @param string $name
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->pathParameters[$name]);
    }
}
