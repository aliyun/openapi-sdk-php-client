<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Vpc;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;

/**
 * Class DescribeVpcsRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Vpc
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class DescribeVpcsRequestMock extends DescribeVpcsRequest
{

    /**
     * @param array $data
     *
     * @return Result
     */
    public function request(array $data)
    {
        $headers = [];
        $body    = \json_encode($data);
        return new Result(new Response(200, $headers, $body), $this);
    }
}
