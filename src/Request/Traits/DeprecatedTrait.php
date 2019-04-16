<?php

namespace AlibabaCloud\Client\Request\Traits;

use RuntimeException;
use AlibabaCloud\Client\Request\Request;

/**
 * @package    AlibabaCloud\Client\Request\Traits
 *
 * @mixin Request
 */
trait DeprecatedTrait
{

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setContent()
    {
        throw new RuntimeException('deprecated since 2.0, Use body() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setMethod()
    {
        throw new RuntimeException('deprecated since 2.0, Use method() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setProtocol()
    {
        throw new RuntimeException('deprecated since 2.0, Use scheme() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getProtocolType()
    {
        throw new RuntimeException('deprecated since 2.0, Use uri->getScheme() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setProtocolType()
    {
        throw new RuntimeException('deprecated since 2.0, Use scheme() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setActionName()
    {
        throw new RuntimeException('deprecated since 2.0, Use action() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setAcceptFormat()
    {
        throw new RuntimeException('deprecated since 2.0, Use format() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getProtocol()
    {
        throw new RuntimeException('deprecated since 2.0, Use uri->getScheme() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getContent()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getMethod()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getHeaders()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function addHeader()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getQueryParameters()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setQueryParameters()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getDomainParameter()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function putDomainParameters()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getActionName()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getAcceptFormat()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getLocationEndpointType()
    {
        throw new RuntimeException('deprecated since 2.0');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getLocationServiceCode()
    {
        throw new RuntimeException('deprecated since 2.0');
    }
}
