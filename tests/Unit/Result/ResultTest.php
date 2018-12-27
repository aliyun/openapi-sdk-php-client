<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * @category     AlibabaCloud
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 */

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
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
     * @param string $value
     */
    public function testSet(array $data, $name, $value)
    {
        // Setup
        $response      = new Response(200, [], \json_encode($data));
        $result        = new Result($response);
        $result->$name = 'test';
        self::assertEquals($value, $result->get($name));
    }

    /**
     * @return array
     */
    public function setData()
    {
        return [
            [
                ['key' => 'value'],
                'string',
                null,
            ],
            [
                ['key' => 'value'],
                'key',
                'test',
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
