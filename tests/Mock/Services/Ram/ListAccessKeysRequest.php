<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ram;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class ListAccessKeysRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ram
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
    public function withUserName($userName)
    {
        $this->userName                     = $userName;
        $this->options['query']['UserName'] = $userName;
        return $this;
    }
}
