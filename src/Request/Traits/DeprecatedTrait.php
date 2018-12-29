<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\Request\Request;

/**
 * @package    AlibabaCloud\Client\Request\Traits
 *
 * @author     Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright  2018 Alibaba Group
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link       https://github.com/aliyun/openapi-sdk-php-client
 *
 * @mixin Request
 */
trait DeprecatedTrait
{
    /**
     * @deprecated
     * @return     string
     */
    public function getContent()
    {
        return isset($this->options['body'])
            ? $this->options['body']
            : null;
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
     * @return     string
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
     * @return $this
     */
    public function setMethod($method)
    {
        return $this->method($method);
    }

    /**
     * @deprecated
     *
     * @return             string
     */
    public function getProtocol()
    {
        return $this->uri->getScheme();
    }

    /**
     * @deprecated         Use scheme() instead.
     *
     * @param string $scheme
     *
     * @return Request
     */
    public function setProtocol($scheme)
    {
        return $this->scheme($scheme);
    }

    /**
     * @deprecated
     * @return     string
     */
    public function getProtocolType()
    {
        return $this->uri->getScheme();
    }

    /**
     * @deprecated
     *
     * @param string $scheme
     *
     * @return DeprecatedTrait
     */
    public function setProtocolType($scheme)
    {
        return $this->scheme($scheme);
    }

    /**
     * @deprecated
     *
     * @return     array
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
     * @return     array
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
     * @return     array
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
     * @return     string
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
     * @return     string
     */
    public function getAcceptFormat()
    {
        return $this->format;
    }

    /**
     * @deprecated
     * @return     string
     */
    public function getLocationEndpointType()
    {
        return $this->locationEndpointType;
    }

    /**
     * @deprecated
     * @return     string
     */
    public function getLocationServiceCode()
    {
        return $this->locationServiceCode;
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
}
