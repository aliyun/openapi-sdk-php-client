<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ecs;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DescribeRegionsRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ecs
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class DescribeRegionsRequest extends RpcRequest
{

    /**
     * DescribeRegionsRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->method('POST');
        $this->product('Ecs');
        $this->version('2014-05-26');
        $this->action('DescribeRegions');
        $this->locationServiceCode  = 'ecs';
        $this->locationEndpointType = 'openAPI';
        $this->options($options);
    }

    /**
     * @var
     */
    private $resourceOwnerId;

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
    private $acceptLanguage;

    /**
     * @var
     */
    private $ownerId;

    /**
     * @var
     */
    private $instanceChargeType;

    /**
     * @var
     */
    private $resourceType;

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
    public function getAcceptLanguage()
    {
        return $this->acceptLanguage;
    }

    /**
     * @param $acceptLanguage
     */
    public function setAcceptLanguage($acceptLanguage)
    {
        $this->acceptLanguage                     = $acceptLanguage;
        $this->options['query']['AcceptLanguage'] = $acceptLanguage;
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
    public function getInstanceChargeType()
    {
        return $this->instanceChargeType;
    }

    /**
     * @param $instanceChargeType
     */
    public function setInstanceChargeType($instanceChargeType)
    {
        $this->instanceChargeType                     = $instanceChargeType;
        $this->options['query']['InstanceChargeType'] = $instanceChargeType;
    }

    /**
     * @return mixed
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * @param $resourceType
     */
    public function setResourceType($resourceType)
    {
        $this->resourceType                     = $resourceType;
        $this->options['query']['ResourceType'] = $resourceType;
    }
}
