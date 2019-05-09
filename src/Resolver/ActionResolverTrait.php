<?php

namespace AlibabaCloud\Client\Resolver;

use ReflectionClass;
use ReflectionException;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Trait ActionResolverTrait
 *
 * @internal
 * @codeCoverageIgnore
 * @mixin Rpc
 * @mixin Roa
 * @mixin Request
 * @package AlibabaCloud\Client\Resolver
 */
trait ActionResolverTrait
{
    /**
     * ActionResolverTrait constructor.
     *
     * @param array $options
     *
     * @throws ReflectionException
     * @throws ClientException
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        if ((new ReflectionClass(AlibabaCloud::class))->hasMethod('appendUserAgent')) {
            if (class_exists('AlibabaCloud\Release')) {
                AlibabaCloud::appendUserAgent('SDK', \AlibabaCloud\Release::VERSION);
            }
        }

        if (!$this->action) {
            $array        = explode('\\', get_class($this));
            $this->action = array_pop($array);
        }
    }
}
