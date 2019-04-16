<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Vpc;

use GuzzleHttp\Psr7\Response;
use AlibabaCloud\Client\Result\Result;

/**
 * Class DescribeVpcsRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Vpc
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
