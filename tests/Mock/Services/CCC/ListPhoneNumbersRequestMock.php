<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CCC;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;

/**
 * Class GetConfigRequestMock
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\CCC
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
