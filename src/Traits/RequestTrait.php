<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Request\UserAgent;

/**
 * Trait RequestTrait.
 *
 *
 * @mixin     AlibabaCloud
 */
trait RequestTrait
{
    /**
     * @param string $name
     * @param string $value
     */
    public static function userAgentAppend($name, $value)
    {
        UserAgent::append($name, $value);
    }

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
