<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ecs;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;

/**
 * Class DescribeAccessPointsRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ecs
 */
class DescribeAccessPointsRequestMock extends DescribeRegionsRequest
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
