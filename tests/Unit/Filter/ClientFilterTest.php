<?php

namespace AlibabaCloud\Client\Tests\Unit\Filter;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Filter\HttpFilter;
use AlibabaCloud\Client\Filter\ClientFilter;
use AlibabaCloud\Client\Exception\ClientException;

class ClientFilterTest extends TestCase
{
    /**
     * @dataProvider retry
     *
     * @param $expected
     * @param $contentType
     * @param $exceptionMessage
     */
    public function testRetry($expected, $contentType, $exceptionMessage)
    {
        try {
            self::assertEquals($expected, ClientFilter::retry($contentType));
        } catch (ClientException $exception) {
            self::assertEquals($exceptionMessage, $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function retry()
    {
        return [
            [
                '',
                '',
                'Retry must be a int',
            ],
            [
                1,
                1,
                'Retry must be a int',
            ],
            [
                'a',
                'a',
                'Retry must be a int',
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
