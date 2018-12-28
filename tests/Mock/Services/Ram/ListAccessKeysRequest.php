<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ram;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class ListAccessKeysRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ram
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class ListAccessKeysRequest extends RpcRequest
{

    /**
     * ListAccessKeysRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->scheme('https');
        $this->method('POST');
        $this->product('Ram');
        $this->version('2015-05-01');
        $this->action('ListAccessKeys');
        $this->options($options);
    }

    /**
     * @var
     */
    private $userName;

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param $userName
     *
     * @return ListAccessKeysRequest
     */
    public function setUserName($userName)
    {
        $this->userName                     = $userName;
        $this->options['query']['UserName'] = $userName;
        return $this;
    }
}
