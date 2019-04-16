<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ecs;

use GuzzleHttp\Psr7\Response;
use AlibabaCloud\Client\Result\Result;

/**
 * Class DescribeAccessPointsRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ecs
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
