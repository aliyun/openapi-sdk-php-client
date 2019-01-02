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
     * @dataProvider requests
     *
     * @param Request $request
     */
    public function testConstruct(Request $request)
    {
        // Setup
        $result = new Result(new Response(), $request);

        // Assert
        self::assertEquals(false, $result->hasKey('key'));
        self::assertEquals(false, $result->get('key'));
        self::assertEquals(null, $result->search('key.name'));
        self::assertObjectNotHasAttribute('key', $result);
        self::assertEquals([], $result->toArray());
        self::assertEquals(0, $result->count());
        self::assertEquals(false, isset($result['key']));
    }

    /**
     * @return array
     */
    public function requests()
    {
        return [
            [(new RpcRequest())->format('json')],
            [(new RpcRequest())->format('xml')],
            [(new RpcRequest())->format('RAW')],
            [(new RpcRequest())->format('unknown')],
        ];
    }

    /**
     * @dataProvider requests
     *
     * @param Request $request
     */
    public function testGetRequest(Request $request)
    {
        // Setup
        $result = new Result(new Response(), $request);

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
     * @dataProvider getData
     *
     * @param array  $data
     * @param string $name
     * @param string $expected
     */
    public function testGet(array $data, $name, $expected)
    {
        // Setup
        $response = new Response(200, [], \json_encode($data));
        $result   = new Result($response);
        self::assertEquals($expected, $result->$name);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [
                ['s' => 's'],
                's',
                's',
            ],
            [
                [],
                'null',
                null,
            ],
        ];
    }

    /**
     * @dataProvider setData
     *
     * @param array  $data
     * @param string $name
     */
    public function testSet(array $data, $name)
    {
        // Setup
        $response      = new Response(200, [], \json_encode($data));
        $result        = new Result($response);
        $result->$name = 'test';
        self::assertEquals('test', $result->get($name));
    }

    /**
     * @return array
     */
    public function setData()
    {
        return [
            [
                [],
                'string',
            ],
            [
                [],
                'key',
            ],
        ];
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
