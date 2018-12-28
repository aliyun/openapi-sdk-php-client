<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CS;

use AlibabaCloud\Client\Request\RoaRequest;

/**
 * Class DescribeClusterServicesRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\CS
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @property-read string $ClusterId
 * @method        string getClusterId()
 * @method        self setClusterId(string $clusterId)
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
