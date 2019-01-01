<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Trait RequestTrait
 *
 * @package   AlibabaCloud\Client\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin     AlibabaCloud
 */
trait RequestTrait
{
    /**
     * @param array $options
     *
     * @return RpcRequest
     */
    public static function rpcRequest(array $options = [])
    {
        return new RpcRequest($options);
    }

    /**
     * @param array $options
     *
     * @return RoaRequest
     */
    public static function roaRequest(array $options = [])
    {
        return new RoaRequest($options);
    }
}
