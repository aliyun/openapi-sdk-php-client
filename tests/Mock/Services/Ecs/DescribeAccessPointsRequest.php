<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Mock\Services\Ecs;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DescribeAccessPointsRequest
 *
 * @package AlibabaCloud\Client\Tests\Mock\Services\Ecs
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
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
        $this->locationServiceCode('ecs');
        $this->locationEndpointType('openAPI');
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
    public function setFilters($Filters)
    {
        $this->Filters = $Filters;
        foreach ($Filters as $i => $iValue) {
            for ($j = 0, $jMax = count($Filters[$i]['Values']); $j < $jMax; $j++) {
                $this->options['query']['Filter.' . ($i + 1) . '.Value.' . ($j + 1)] = $Filters[$i]['Values'][$j];
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
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param $pageSize
     *
     * @return DescribeAccessPointsRequest
     */
    public function setPageSize($pageSize)
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
    public function setOwnerId($ownerId)
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
    public function setType($type)
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
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber                     = $pageNumber;
        $this->options['query']['PageNumber'] = $pageNumber;
    }
}
