<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CCC;

use GuzzleHttp\Psr7\Response;
use AlibabaCloud\Client\Result\Result;

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
