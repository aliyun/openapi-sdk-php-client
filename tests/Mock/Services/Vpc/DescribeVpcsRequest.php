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

namespace AlibabaCloud\Client\Tests\Mock\Services\Vpc;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DescribeVpcsRequest
 *
 * @package AlibabaCloud\Client\Tests\Mock\Services\Vpc
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */
class DescribeVpcsRequest extends RpcRequest
{

    /**
     * DescribeVpcsRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->method('POST');
        $this->product('Vpc');
        $this->version('2016-04-28');
        $this->action('DescribeVpcs');
        $this->locationServiceCode  = 'vpc';
        $this->locationEndpointType = 'openAPI';
        $this->options($options);
    }

    /**
     * @var
     */
    private $vpcName;

    /**
     * @var
     */
    private $resourceGroupId;

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
    private $vpcId;

    /**
     * @var
     */
    private $ownerAccount;

    /**
     * @var
     */
    private $pageSize;

    /**
     * @var
     */
    private $isDefault;

    /**
     * @var
     */
    private $ownerId;

    /**
     * @var
     */
    private $pageNumber;

    /**
     * @return mixed
     */
    public function getVpcName()
    {
        return $this->vpcName;
    }

    /**
     * @param $vpcName
     */
    public function setVpcName($vpcName)
    {
        $this->vpcName                     = $vpcName;
        $this->options['query']['VpcName'] = $vpcName;
    }

    /**
     * @return mixed
     */
    public function getResourceGroupId()
    {
        return $this->resourceGroupId;
    }

    /**
     * @param $resourceGroupId
     */
    public function setResourceGroupId($resourceGroupId)
    {
        $this->resourceGroupId                     = $resourceGroupId;
        $this->options['query']['ResourceGroupId'] = $resourceGroupId;
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
    public function getVpcId()
    {
        return $this->vpcId;
    }

    /**
     * @param $vpcId
     */
    public function setVpcId($vpcId)
    {
        $this->vpcId                     = $vpcId;
        $this->options['query']['VpcId'] = $vpcId;
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
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param $pageSize
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize                     = $pageSize;
        $this->options['query']['PageSize'] = $pageSize;
    }

    /**
     * @return mixed
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param $isDefault
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault                     = $isDefault;
        $this->options['query']['IsDefault'] = $isDefault;
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
