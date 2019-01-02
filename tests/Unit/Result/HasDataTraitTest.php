<?php

namespace AlibabaCloud\Client\Tests\Unit\Result;

use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class HasDataTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Result
 *
 * @coversDefaultClass \AlibabaCloud\Client\Result\Result
 */
class HasDataTraitTest extends TestCase
{

    /**
     * @covers ::getIterator
     */
    public function testGetIterator()
    {
        // Setup
        $result = new Result(new Response());

        // Assert
        self::assertInstanceOf(\ArrayIterator::class, $result->getIterator());
    }

    /**
     * @covers       ::count
     * @dataProvider countData
     *
     * @param array $data
     * @param int   $count
     */
    public function testCount(array $data, $count)
    {
        // Setup
        $response = new Response(200, [], \json_encode($data));
        $result   = new Result($response);
        self::assertEquals($count, $result->count());
    }

    /**
     * @return array
     */
    public function countData()
    {
        return [
            [
                ['key' => 'value'],
                1,
            ],
            [
                [],
                0,
            ],
            [
                [1, 2, 3, 4],
                4,
            ],
        ];
    }

    /**
     * @covers       ::search
     * @dataProvider searchData
     *
     * @param array  $data
     * @param string $search
     * @param string $value
     */
    public function testSearch(array $data, $search, $value)
    {
        // Setup
        $response = new Response(200, [], \json_encode($data));
        $result   = new Result($response);
        self::assertEquals($value, $result->search($search));
    }

    /**
     * @return array
     */
    public function searchData()
    {
        return [
            [
                ['key' => 'value'],
                'key',
                'value',
            ],
            [
                ['key' => 'value'],
                'key.null',
                null,
            ],
            [
                [
                    'key' => [
                        'keys' => [
                            'a',
                            'b',
                            'c',
                        ],
                    ],
                ],
                'key.keys[2]',
                'c',
            ],
        ];
    }

    /**
     * @covers       ::hasKey
     * @dataProvider hasKeyData
     *
     * @param array  $data
     * @param string $key
     * @param bool   $bool
     */
    public function testHasKey(array $data, $key, $bool)
    {
        // Setup
        $response = new Response(200, [], \json_encode($data));
        $result   = new Result($response);
        self::assertEquals($bool, $result->hasKey($key));
    }

    /**
     * @return array
     */
    public function hasKeyData()
    {
        return [
            [
                ['key' => 'value'],
                'key2',
                false,
            ],
            [
                ['key' => 'value'],
                'key',
                true,
            ],
        ];
    }

    /**
     * @covers       ::get
     * @dataProvider getData
     *
     * @param array  $data
     * @param string $key
     * @param string $value
     */
    public function testGet(array $data, $key, $value)
    {
        // Setup
        $response = new Response(200, [], \json_encode($data));
        $result   = new Result($response);
        self::assertEquals($value, $result->get($key));
        self::assertEquals($value, $result[$key]);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [
                ['key' => 'value'],
                'key2',
                null,
            ],
            [
                ['key' => 'value'],
                'key',
                'value',
            ],
        ];
    }
}
