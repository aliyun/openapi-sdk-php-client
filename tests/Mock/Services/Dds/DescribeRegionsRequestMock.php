<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Dds;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;

/**
 * Class DescribeRegionsRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Dds
 */
class DescribeRegionsRequestMock extends DescribeRegionsRequest
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
