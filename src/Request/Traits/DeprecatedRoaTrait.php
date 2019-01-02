<?php

namespace AlibabaCloud\Client\Request\Traits;

/**
 * @package    AlibabaCloud\Client\Request\Traits
 */
trait DeprecatedRoaTrait
{

    /**
     * @deprecated
     *
     * @param string $uriPattern
     *
     * @return $this
     */
    public function setUriPattern($uriPattern)
    {
        return $this->pathPattern($uriPattern);
    }

    /**
     * @deprecated
     *
     * @return string
     */
    public function getUriPattern()
    {
        return $this->pathPattern;
    }

    /**
     * @deprecated
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
     * @deprecated
     *
     * @return array
     */
    public function getPathParameters()
    {
        return $this->pathParameters;
    }
}
