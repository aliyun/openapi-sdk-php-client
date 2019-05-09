<?php

namespace AlibabaCloud\Client\Resolver;

use AlibabaCloud\Client\Request\RoaRequest;

/**
 * Class Roa
 *
 * @internal
 * @codeCoverageIgnore
 * @package AlibabaCloud\Client\Resolver
 */
abstract class Roa extends RoaRequest
{
    use ActionResolverTrait;
    use CallTrait;

    /**
     * @return mixed
     */
    private function &parameterPosition()
    {
        return $this->pathParameters;
    }
}
