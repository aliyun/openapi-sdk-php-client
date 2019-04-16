<?php

namespace AlibabaCloud\Client\Request\Traits;

use RuntimeException;

/**
 * @package    AlibabaCloud\Client\Request\Traits
 * @codeCoverageIgnore
 */
trait DeprecatedRoaTrait
{
    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function putPathParameter()
    {
        throw new RuntimeException('deprecated since 2.0, Use pathParameter() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function setUriPattern()
    {
        throw new RuntimeException('deprecated since 2.0, Use pathPattern() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getUriPattern()
    {
        throw new RuntimeException('deprecated since 2.0, Use pathPattern instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public function getPathParameters()
    {
        throw new RuntimeException('deprecated since 2.0, Use pathParameters instead.');
    }
}
