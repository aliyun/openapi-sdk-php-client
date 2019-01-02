<?php

namespace AlibabaCloud\Client\Request\Traits;

/**
 * @package    AlibabaCloud\Client\Request\Traits
 */
trait DeprecatedRoaTrait
{

    /**
     * @deprecated deprecated since version 2.0, Use pathPattern() instead.
     *
     * @param string $pathPattern
     *
     * @return $this
     */
    public function setUriPattern($pathPattern)
    {
        return $this->pathPattern($pathPattern);
    }

    /**
     * @deprecated deprecated since version 2.0, Use pathPattern instead.
     *
     * @return string
     */
    public function getUriPattern()
    {
        return $this->pathPattern;
    }

    /**
     * @deprecated deprecated since version 2.0, Use pathParameter() instead.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function putPathParameter($name, $value)
    {
        return $this->pathParameter($name, $value);
    }

    /**
     * @deprecated deprecated since version 2.0, Use pathParameters instead.
     *
     * @return array
     */
    public function getPathParameters()
    {
        return $this->pathParameters;
    }
}
