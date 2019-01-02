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
     *
     * @return string
     */
    protected function propertyNameByMethodName($methodName)
    {
        return \mb_strcut($methodName, 3);
    }
}
