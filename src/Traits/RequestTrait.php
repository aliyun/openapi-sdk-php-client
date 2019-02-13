<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Request\UserAgent;

/**
 * Trait RequestTrait
 *
 * @package   AlibabaCloud\Client\Traits
 *
 * @mixin     AlibabaCloud
 */
trait RequestTrait
{
    /**
     * @param string $name
     * @param string $value
     */
    public static function appendUserAgent($name, $value)
    {
        UserAgent::append($name, $value);
    }

    /**
     * @param array $userAgent
     */
    public static function withUserAgent(array $userAgent)
    {
        UserAgent::with($userAgent);
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
