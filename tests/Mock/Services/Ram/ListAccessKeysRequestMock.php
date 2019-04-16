<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Ram;

use GuzzleHttp\Psr7\Response;
use AlibabaCloud\Client\Result\Result;

/**
 * Class ListAccessKeysRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Ram
 */
class ListAccessKeysRequestMock extends ListAccessKeysRequest
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
