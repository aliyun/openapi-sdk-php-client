<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CS;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;

/**
 * Class DescribeClusterServicesRequestMock
 *
 * @package       AlibabaCloud\Client\Tests\Mock\Services\CS
 *
 * @property-read string $ClusterId
 * @method        string getClusterId()
 * @method        self withClusterId(string $clusterId)
 */
class DescribeClusterServicesRequestMock extends DescribeClusterServicesRequest
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
