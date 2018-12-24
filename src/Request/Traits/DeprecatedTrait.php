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

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\Request\Request;

/**
 * @todo      Old methods point to new data structures, but they will be discarded in the future.
 * @deprecated
 * @package AlibabaCloud\Client\Request\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 *
 * @mixin     Request
 * @codeCoverageIgnore
 */
trait DeprecatedTrait
{
    /**
     * @deprecated
     * @return string
     */
    public function getContent()
    {
        return $this->options['body'];
    }

    /**
     * @deprecated
     *
     * @param $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        return $this->body($content);
    }

    /**
     * @deprecated
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @deprecated
     *
     * @param string $method
     *
     * @return DeprecatedTrait
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @deprecated  Use self::protocol instead.
     * @codeCoverageIgnore
     *
     * @param string $protocol
     *
     * @return Request
     */
    public function setProtocol($protocol)
    {
        return $this->protocol($protocol);
    }

    /**
     * @deprecated
     * @return string
     */
    public function getProtocolType()
    {
        return $this->protocol;
    }

    /**
     * @deprecated
     *
     * @param string $protocol
     *
     * @return DeprecatedTrait
     */
    public function setProtocolType($protocol)
    {
        return $this->protocol($protocol);
    }

    /**
     * @param array $post
     *
     * @return bool|string
     */
    public static function getPostHttpBody(array $post)
    {
        $content = '';
        foreach ($post as $apiParamKey => $apiParamValue) {
            $content .= "$apiParamKey=" . urlencode($apiParamValue) . '&';
        }
        return substr($content, 0, -1);
    }

    /**
     * @deprecated
     * @return array
     */
    public function getHeaders()
    {
        return isset($this->options['headers'])
            ? $this->options['headers']
            : [];
    }

    /**
     * @deprecated
     *
     * @param string $headerKey
     * @param string $headerValue
     *
     * @return Request
     */
    public function addHeader($headerKey, $headerValue)
    {
        $this->options['headers'][$headerKey] = $headerValue;
        return $this;
    }

    /**
     * @deprecated
     * @return array
     */
    public function getQueryParameters()
    {
        return isset($this->options['query'])
            ? $this->options['query']
            : [];
    }

    /**
     * @deprecated
     *
     * @param string       $name
     * @param string|mixed $value
     *
     * @return Request
     */
    public function setQueryParameters($name, $value)
    {
        $this->options['query'][$name] = $value;
        return $this;
    }

    /**
     * @deprecated
     * @return array
     */
    public function getDomainParameter()
    {
        return isset($this->options['form_params'])
            ? $this->options['form_params']
            : [];
    }

    /**
     * @deprecated
     *
     * @param string $name
     * @param string $value
     *
     * @return Request
     */
    public function putDomainParameters($name, $value)
    {
        $this->options['form_params'][$name] = $value;
        return $this;
    }

    /**
     * @deprecated
     *
     * @param $actionName
     *
     * @return self
     */
    public function setActionName($actionName)
    {
        return $this->action($actionName);
    }

    /**
     * @deprecated
     * @return string
     */
    public function getActionName()
    {
        return $this->action;
    }

    /**
     * @deprecated
     *
     * @param string $format
     *
     * @return self
     */
    public function setAcceptFormat($format)
    {
        return $this->format($format);
    }

    /**
     * @deprecated
     * @return string
     */
    public function getAcceptFormat()
    {
        return $this->format;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getLocationEndpointType()
    {
        return $this->locationEndpointType;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getLocationServiceCode()
    {
        return $this->locationServiceCode;
    }
}
