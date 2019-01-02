<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CCC;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class ListPhoneNumbersRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\CCC
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
        $this->serviceCode  = 'ccc';
        $this->endpointType = 'openAPI';
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
    public function withOutboundOnly($outboundOnly)
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
    public function withInstanceId($instanceId)
    {
        $this->instanceId                     = $instanceId;
        $this->options['query']['InstanceId'] = $instanceId;
        return $this;
    }
}
