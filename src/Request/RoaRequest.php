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
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @mixin RoaRequest
 */
class RoaRequest extends Request
{
    use /**
     * @scrutinizer ignore-deprecated
     */
        DeprecatedRoaTrait;
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
        $this->options['query']['Version']         = &$this->version;
        $this->options['headers']['x-acs-version'] = &$this->version;
    }

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

        $queryString = $this->buildQueryString($this->assignPathParameters());
        $signString  .= $queryString;

        $this->options['headers']['Authorization'] = 'acs '
                                                     . $credential->getAccessKeyId()
                                                     . ':'
                                                     . $this->httpClient()
                                                            ->getSignature()
                                                            ->sign(
                                                                $signString,
                                                                $credential->getAccessKeySecret()
                                                            );

        $this->uri = $this->uriComponents->getScheme()
                     . '://'
                     . $this->uriComponents->getHost()
                     . $queryString;
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
        $sortMap  = isset($this->options['query'])
            ? $this->options['query']
            : [];
        if (isset($uriParts[1])) {
            $sortMap[$uriParts[1]] = null;
        }
        $queryString = $uriParts[0];
        if (count($uriParts)) {
            $queryString .= '?';
        }

        $queryString = $this->ksort($queryString, $sortMap);

        if (0 < count($sortMap)) {
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
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (\strpos($name, 'get', 0) !== false) {
            $name = $this->propertyNameByMethodName($name);
            return isset($this->pathParameters[$name])
                ? $this->pathParameters[$name]
                : null;
        }

        if (\strpos($name, 'set', 0) !== false) {
            $name                        = $this->propertyNameByMethodName($name);
            $this->pathParameters[$name] = $arguments[0];
        }

        return $this;
    }
}
