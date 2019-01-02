<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\Request\Request;

/**
 * Class MagicTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
 *
 * @mixin Request
 */
trait MagicTrait
{
    /**
     * @param string $methodName
     * @param int    $start
     *
     * @return string
     */
    protected function propertyNameByMethodName($methodName, $start = 3)
    {
        return \mb_strcut($methodName, $start);
    }
}
