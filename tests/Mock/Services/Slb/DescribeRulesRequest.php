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
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Mock\Services\Slb;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DescribeRulesRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Slb
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
        $this->locationServiceCode  = 'slb';
        $this->locationEndpointType = 'openAPI';
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
