<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Request\Request;

/**
 * @package    AlibabaCloud\Client\Request\Traits
 *
 * @mixin Request
 */
trait DeprecatedTrait
{
    /**
     * @deprecated deprecated since version 2.0, Use $this->options['body'] instead.
     *
     * @return     string
     */
    public function getContent()
    {
        return isset($this->options['body'])
            ? $this->options['body']
            : null;
    }

    /**
     * @deprecated deprecated since version 2.0, Use body() instead.
     *
     * @param $content
     *
     * @return $this
     * @throws ClientException
     */
    public function setContent($content)
    {
        return $this->body($content);
    }

    /**
     * @deprecated deprecated since version 2.0, Use method instead.
     *
     * @return     string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @deprecated deprecated since version 2.0, Use method() instead.
     *
     * @param string $method
     *
     * @return $this
     * @throws ClientException
     */
    public function setMethod($method)
    {
        return $this->method($method);
    }

    /**
     * @deprecated deprecated since version 2.0, Use uri->getScheme() instead.
     *
     * @return             string
     */
    public function getProtocol()
    {
        return $this->uri->getScheme();
    }

    /**
     * @deprecated deprecated since version 2.0, Use scheme() instead.
     *
     * @param string $scheme
     *
     * @return $this
     * @throws ClientException
     */
    public function setProtocol($scheme)
    {
        return $this->scheme($scheme);
    }

    /**
     * @deprecated deprecated since version 2.0, Use uri->getScheme() instead.
     *
     * @return     string
     */
    public function getProtocolType()
    {
        return $this->uri->getScheme();
    }

    /**
     * @deprecated deprecated since version 2.0, Use scheme() instead.
     *
     * @param string $scheme
     *
     * @return $this
     * @throws ClientException
     */
    public function setProtocolType($scheme)
    {
        return $this->scheme($scheme);
    }

    /**
     * @deprecated deprecated since version 2.0, Use $this->options['headers'] instead.
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
     * @deprecated deprecated since version 2.0, Use $this->options['headers'] instead.
     *
     * @param string $headerKey
     * @param string $headerValue
     *
     * @return $this
     */
    public function addHeader($headerKey, $headerValue)
    {
        $this->options['headers'][$headerKey] = $headerValue;

        return $this;
    }

    /**
     * @deprecated deprecated since version 2.0.
     * @return     array
     */
    public function getQueryParameters()
    {
        return isset($this->options['query'])
            ? $this->options['query']
            : [];
    }

    /**
     * @deprecated deprecated since version 2.0.
     *
     * @param string       $name
     * @param string|mixed $value
     *
     * @return $this
     */
    public function setQueryParameters($name, $value)
    {
        $this->options['query'][$name] = $value;

        return $this;
    }

    /**
     * @deprecated deprecated since version 2.0.
     * @return     array
     */
    public function getDomainParameter()
    {
        return isset($this->options['form_params'])
            ? $this->options['form_params']
            : [];
    }

    /**
     * @deprecated deprecated since version 2.0.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function putDomainParameters($name, $value)
    {
        $this->options['form_params'][$name] = $value;

        return $this;
    }

    /**
     * @deprecated deprecated since version 2.0, Use action() instead.
     *
     * @param $actionName
     *
     * @return self
     * @throws ClientException
     */
    public function setActionName($actionName)
    {
        return $this->action($actionName);
    }

    /**
     * @deprecated deprecated since version 2.0.
     * @return     string
     */
    public function getActionName()
    {
        return $this->action;
    }

    /**
     * @deprecated deprecated since version 2.0, Use format() instead.
     *
     * @param string $format
     *
     * @return self
     * @throws ClientException
     */
    public function setAcceptFormat($format)
    {
        return $this->format($format);
    }

    /**
     * @deprecated deprecated since version 2.0.
     * @return     string
     */
    public function getAcceptFormat()
    {
        return $this->format;
    }

    /**
     * @deprecated deprecated since version 2.0.
     * @return     string
     */
    public function getLocationEndpointType()
    {
        return $this->endpointType;
    }

    /**
     * @deprecated deprecated since version 2.0.
     *
     * @return     string
     */
    public function getLocationServiceCode()
    {
        return $this->serviceCode;
    }
}
