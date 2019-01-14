<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ecs;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DescribeAccessPointsRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ecs
 */
class DescribeAccessPointsRequest extends RpcRequest
{

    /**
     * DescribeAccessPointsRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->method('POST');
        $this->version('2014-05-26');
        $this->action('DescribeAccessPoints');
        $this->serviceCode('ecs');
        $this->product('Ecs');
        $this->endpointType('openAPI');
        $this->options($options);
    }

    /**
     * @var
     */
    private $Filters;

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
    private $pageSize;

    /**
     * @var
     */
    private $ownerId;

    /**
     * @var
     */
    private $type;

    /**
     * @var
     */
    private $pageNumber;

    /**
     * @return mixed
     */
    public function getFilters()
    {
        return $this->Filters;
    }

    /**
     * @param $Filters
     */
    public function withFilters($Filters)
    {
        $this->Filters = $Filters;
        foreach ($Filters as $i => $iValue) {
            foreach ($Filters[$i]['Values'] as $j => $jValue) {
                $this->options['query']['Filter.' . ($i + 1) . '.Value.' . ($j + 1)] = $jValue;
            }
            $this->options['query']['Filter.' . ($i + 1) . '.Key'] = $Filters[$i]['Key'];
        }
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
    public function withResourceOwnerId($resourceOwnerId)
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
    public function withResourceOwnerAccount($resourceOwnerAccount)
    {
        $this->resourceOwnerAccount                     = $resourceOwnerAccount;
        $this->options['query']['ResourceOwnerAccount'] = $resourceOwnerAccount;
    }

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param $pageSize
     *
     * @return DescribeAccessPointsRequest
     */
    public function withPageSize($pageSize)
    {
        $this->pageSize                     = $pageSize;
        $this->options['query']['PageSize'] = $pageSize;
        return $this;
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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function withType($type)
    {
        $this->type                     = $type;
        $this->options['query']['Type'] = $type;
    }

    /**
     * @return mixed
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * @param $pageNumber
     */
    public function withPageNumber($pageNumber)
    {
        $this->pageNumber                     = $pageNumber;
        $this->options['query']['PageNumber'] = $pageNumber;
    }
}
