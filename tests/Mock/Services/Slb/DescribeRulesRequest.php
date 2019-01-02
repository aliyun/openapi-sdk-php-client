<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Slb;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DescribeRulesRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Slb
 */
class DescribeRulesRequest extends RpcRequest
{

    /**
     * DescribeRulesRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->method('POST');
        $this->product('Slb');
        $this->version('2014-05-15');
        $this->action('DescribeRules');
        $this->serviceCode  = 'slb';
        $this->endpointType = 'openAPI';
        $this->options($options);
    }

    /**
     * @var
     */
    private $access_key_id;

    /**
     * @var
     */
    private $resourceOwnerId;

    /**
     * @var
     */
    private $listenerPort;

    /**
     * @var
     */
    private $loadBalancerId;

    /**
     * @var
     */
    private $resourceOwnerAccount;

    /**
     * @var
     */
    private $ownerAccount;

    /**
     * @var
     */
    private $ownerId;

    /**
     * @var
     */
    private $tags;

    /**
     * @return mixed
     */
    public function getaccess_key_id()
    {
        return $this->access_key_id;
    }

    /**
     * @param $access_key_id
     */
    public function setaccess_key_id($access_key_id)
    {
        $this->access_key_id                     = $access_key_id;
        $this->options['query']['access_key_id'] = $access_key_id;
    }

    /**
     * @return mixed
     */
    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    /**
     * @param $resourceOwnerId
     */
    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId                     = $resourceOwnerId;
        $this->options['query']['ResourceOwnerId'] = $resourceOwnerId;
    }

    /**
     * @return mixed
     */
    public function getListenerPort()
    {
        return $this->listenerPort;
    }

    /**
     * @param $listenerPort
     *
     * @return DescribeRulesRequest
     */
    public function setListenerPort($listenerPort)
    {
        $this->listenerPort                     = $listenerPort;
        $this->options['query']['ListenerPort'] = $listenerPort;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLoadBalancerId()
    {
        return $this->loadBalancerId;
    }

    /**
     * @param $loadBalancerId
     *
     * @return DescribeRulesRequest
     */
    public function setLoadBalancerId($loadBalancerId)
    {
        $this->loadBalancerId                     = $loadBalancerId;
        $this->options['query']['LoadBalancerId'] = $loadBalancerId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResourceOwnerAccount()
    {
        return $this->resourceOwnerAccount;
    }

    /**
     * @param $resourceOwnerAccount
     */
    public function setResourceOwnerAccount($resourceOwnerAccount)
    {
        $this->resourceOwnerAccount                     = $resourceOwnerAccount;
        $this->options['query']['ResourceOwnerAccount'] = $resourceOwnerAccount;
    }

    /**
     * @return mixed
     */
    public function getOwnerAccount()
    {
        return $this->ownerAccount;
    }

    /**
     * @param $ownerAccount
     */
    public function setOwnerAccount($ownerAccount)
    {
        $this->ownerAccount                     = $ownerAccount;
        $this->options['query']['OwnerAccount'] = $ownerAccount;
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
    public function setOwnerId($ownerId)
    {
        $this->ownerId                     = $ownerId;
        $this->options['query']['OwnerId'] = $ownerId;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param $tags
     */
    public function setTags($tags)
    {
        $this->tags                     = $tags;
        $this->options['query']['Tags'] = $tags;
    }
}
