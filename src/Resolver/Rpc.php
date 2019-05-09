<?php

namespace AlibabaCloud\Client\Resolver;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class Rpc
 *
 * @internal
 * @codeCoverageIgnore
 * @package AlibabaCloud\Client\Resolver
 */
abstract class Rpc extends RpcRequest
{
    use ActionResolverTrait;
    use CallTrait;

    /**
     * @return mixed
     */
    private function &parameterPosition()
    {
        return $this->options['query'];
    }
}
