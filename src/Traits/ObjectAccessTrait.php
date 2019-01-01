<?php

namespace AlibabaCloud\Client\Traits;

/**
 * Trait ObjectAccessTrait
 *
 * @package   AlibabaCloud\Client\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
trait ObjectAccessTrait
{
    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->data[$name])
            ? $this->data[$name]
            : null;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @param $name
     *
     * @return void
     */
    public function __unset($name)
    {
        unset($this->data[$name]);
    }
}
