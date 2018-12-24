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

namespace AlibabaCloud\Client\Tests\Mock\Services\CCC;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class ListPhoneNumbersRequest
 *
 * @package AlibabaCloud\Client\Tests\Mock\Services\CCC
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */
class ListPhoneNumbersRequest extends RpcRequest
{

    /**
     * GetConfigRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->product('CCC');
        $this->version('2017-07-05');
        $this->action('ListPhoneNumbers');
        $this->locationServiceCode  = 'ccc';
        $this->locationEndpointType = 'openAPI';
        $this->method('POST');
        $this->options($options);
    }

    /**
     * @var
     */
    private $outboundOnly;

    /**
     * @var
     */
    private $instanceId;

    /**
     * @return mixed
     */
    public function getOutboundOnly()
    {
        return $this->outboundOnly;
    }

    /**
     * @param $outboundOnly
     *
     * @return ListPhoneNumbersRequest
     */
    public function setOutboundOnly($outboundOnly)
    {
        $this->outboundOnly                     = $outboundOnly;
        $this->options['query']['OutboundOnly'] = $outboundOnly;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * @param $instanceId
     *
     * @return ListPhoneNumbersRequest
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId                     = $instanceId;
        $this->options['query']['InstanceId'] = $instanceId;
        return $this;
    }
}
