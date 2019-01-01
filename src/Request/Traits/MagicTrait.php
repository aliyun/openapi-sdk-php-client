<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\Request\Request;

/**
 * Class MagicTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
