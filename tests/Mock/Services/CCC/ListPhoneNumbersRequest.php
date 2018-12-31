<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CCC;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class ListPhoneNumbersRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\CCC
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
