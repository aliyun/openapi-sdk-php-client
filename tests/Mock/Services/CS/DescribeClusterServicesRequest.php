<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CS;

use AlibabaCloud\Client\Request\RoaRequest;

/**
 * Class DescribeClusterServicesRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\CS
 *
 * @property-read string $ClusterId
 * @method        string getClusterId()
 * @method        self withClusterId(string $clusterId)
 */
class DescribeClusterServicesRequest extends RoaRequest
{
    /**
     * @var string
     */
    public $pathPattern = '/clusters/[ClusterId]/services';
    /**
     * @var string
     */
    public $product = 'CS';
    /**
     * @var string
     */
    public $version = '2015-12-15';
    /**
     * @var string
     */
    public $action = 'DescribeClusterServices';

    /**
     * DescribeClusterServicesRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->options($options);
    }
}
