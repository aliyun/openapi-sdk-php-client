<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Nlp;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;

/**
 * Class NlpRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Vpc
 */
class NlpRequestMock extends NlpRequest
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
