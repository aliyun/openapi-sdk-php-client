<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CCC;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;

/**
 * Class GetConfigRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\CCC
 */
class ListPhoneNumbersRequestMock extends ListPhoneNumbersRequest
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
