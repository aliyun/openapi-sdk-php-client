<?php

namespace AlibabaCloud\Client\Tests\Unit\Filter;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Filter\HttpFilter;
use AlibabaCloud\Client\Exception\ClientException;

class HttpFilterTest extends TestCase
{
    /**
     * @dataProvider contentType
     *
     * @param $expected
     * @param $contentType
     * @param $exceptionMessage
     */
    public function testContentType($expected, $contentType, $exceptionMessage)
    {
        try {
            self::assertEquals($expected, HttpFilter::contentType($contentType));
        } catch (ClientException $exception) {
            self::assertEquals($exceptionMessage, $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function contentType()
    {
        return [
            [
                '',
                '',
                'Content-Type cannot be empty',
            ],
            [
                1,
                1,
                'Content-Type must be a string',
            ],
            [
                'a',
                'a',
                'a',
            ],
        ];
    }


    /**
     * @dataProvider accept
     *
     * @param $expected
     * @param $contentType
     * @param $exceptionMessage
     */
    public function testAccept($expected, $contentType, $exceptionMessage)
    {
        try {
            self::assertEquals($expected, HttpFilter::accept($contentType));
        } catch (ClientException $exception) {
            self::assertEquals($exceptionMessage, $exception->getMessage());
        }
    }


    /**
     * @return array
     */
    public function accept()
    {
        return [
            [
                '',
                '',
                'Accept cannot be empty',
            ],
            [
                1,
                1,
                'Accept must be a string',
            ],
            [
                'a',
                'a',
                'a',
            ],
        ];
    }
}
