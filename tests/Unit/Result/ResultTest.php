<?php

namespace AlibabaCloud\Client\Tests\Unit\Result;

use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ResultTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Result
 */
class ResultTest extends TestCase
{

    /**
     * @return array
     */
    public function requests()
    {
        return [
            [
                [
                    'key' => [
                        'name' => 'value',
                    ],
                ],
                (new RpcRequest())->format('json'),
            ],
            [
                [
                    'key' => [
                        'name' => 'value',
                    ],
                ],
                (new RpcRequest())->format('xml'),
            ],
            [
                [
                    'key' => [
                        'name' => 'value',
                    ],
                ],
                (new RpcRequest())->format('RAW'),
            ],
            [
                [
                    'key' => [
                        'name' => 'value',
                    ],
                ],
                (new RpcRequest())->format('unknown'),
            ],
        ];
    }

    /**
     * @dataProvider requests
     *
     * @param array   $data
     * @param Request $request
     */
    public function testGetRequest(array $data, Request $request)
    {
        // Setup
        $response = new Response(200, [], \json_encode($data));
        $result   = new Result($response, $request);

        // Assert
        self::assertInstanceOf(Request::class, $result->getRequest());
    }

    public function testGetResponse()
    {
        // Setup
        $result = new Result(new Response());

        // Assert
        self::assertInstanceOf(Response::class, $result->getResponse());
    }

    /**
     * @dataProvider responses
     *
     * @param Response $response
     * @param bool     $bool
     */
    public function testIsSuccess(Response $response, $bool)
    {
        // Setup
        $result = new Result($response);

        // Assert
        self::assertEquals($bool, $result->isSuccess());
    }

    /**
     * @return array
     */
    public function responses()
    {
        return [
            [
                new Response(),
                true,
            ],
            [
                new Response(301),
                false,
            ],
            [
                new Response(199),
                false,
            ],
        ];
    }

    public function testToString()
    {
        // Setup
        $result = new Result(new Response());

        // Assert
        self::assertEquals('', (string)$result);
    }

    /**
     * @dataProvider issetData
     *
     * @param array  $data
     * @param string $name
     * @param string $expected
     */
    public function testIsset(array $data, $name, $expected)
    {
        // Setup
        $response = new Response(200, [], \json_encode($data));
        $result   = new Result($response);

        // Assert
        self::assertEquals($expected, isset($result->$name));
    }

    /**
     * @return array
     */
    public function issetData()
    {
        return [
            [
                ['key' => 'value'],
                'key',
                true,
            ],
            [
                [],
                'null',
                false,
            ],
        ];
    }
}
