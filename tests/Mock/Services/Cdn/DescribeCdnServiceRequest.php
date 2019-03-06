<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Cdn;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DescribeCdnServiceRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Cdn
 */
class DescribeCdnServiceRequest extends RpcRequest
{

    /**
     * @var
     */
    private $securityToken;
    /**
     * @var
     */
    private $ownerId;

    /**
     * DescribeCdnServiceRequest constructor.
     *
     * @param array $options
     *
     * @throws ClientException
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->method('POST');
        $this->product('Cdn');
        $this->version('2014-11-11');
        $this->action('DescribeCdnService');
        $this->options($options);
    }

    /**
     * @return mixed
     */
    public function getSecurityToken()
    {
        return $this->securityToken;
    }

    /**
     * @param $securityToken
     */
    public function withSecurityToken($securityToken)
    {
        $this->securityToken                     = $securityToken;
        $this->options['query']['SecurityToken'] = $securityToken;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param $ownerId
     */
    public function withOwnerId($ownerId)
    {
        $this->ownerId                     = $ownerId;
        $this->options['query']['OwnerId'] = $ownerId;
    }
}
