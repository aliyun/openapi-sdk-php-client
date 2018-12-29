<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\Request\Request;

/**
 * Trait ArrayAccessTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @mixin     Request
 */
trait ArrayAccessTrait
{
    /**
     * This method returns a reference to the variable to allow for indirect
     * array modification (e.g., $foo['bar']['baz'] = 'qux').
     *
     * @param string $offset
     *
     * @return mixed|null
     */
    public function & offsetGet($offset)
    {
        if (isset($this->parameters[$offset])) {
            return $this->parameters[$offset];
        }

        $value = null;
        return $value;
    }

    /**
     * @param string       $offset
     * @param string|mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->parameters[$offset] = $value;
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->parameters[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->parameters[$offset]);
    }
}
