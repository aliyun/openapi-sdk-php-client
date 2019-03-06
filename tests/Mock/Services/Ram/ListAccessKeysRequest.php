<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ram;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class ListAccessKeysRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ram
 */
class ListAccessKeysRequest extends RpcRequest
{

    /**
     * @var
     */
    private $userName;

    /**
     * ListAccessKeysRequest constructor.
     *
     * @param array $options
     *
     * @throws ClientException
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
