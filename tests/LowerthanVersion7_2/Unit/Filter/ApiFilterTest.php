<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Filter;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Filter\HttpFilter;
use AlibabaCloud\Client\Filter\ApiFilter;
use AlibabaCloud\Client\Exception\ClientException;

class ApiFilterTest extends TestCase
{
    /**
     * @dataProvider endpointSuffix
     *
     * @param $expected
     * @param $contentType
     * @param $exceptionMessage
     */
    public function testEndpointSuffix($expected, $contentType, $exceptionMessage)
    {
        try {
            self::assertEquals($expected, ApiFilter::endpointSuffix($contentType));
        } catch (ClientException $exception) {
            self::assertEquals($exceptionMessage, $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function endpointSuffix()
    {
        return [
            [
                1,
                1,
                'Endpoint Suffix must be a string',
            ],
            [
                '',
                '',
                'Endpoint Suffix cannot be empty',
            ],
            [
                'EndpointSuffix中文',
                'EndpointSuffix中文',
                'Invalid Endpoint Suffix',
            ],
            [
                'suffix',
                'suffix',
                '',
            ]
        ];
    }

    /**
     * @dataProvider network
     *
     * @param $expected
     * @param $contentType
     * @param $exceptionMessage
     */
    public function testNetwork($expected, $contentType, $exceptionMessage)
    {
        try {
            self::assertEquals($expected, ApiFilter::network($contentType));
        } catch (ClientException $exception) {
            self::assertEquals($exceptionMessage, $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function network()
    {
        return [
            [
                1,
                1,
                'Network Suffix must be a string',
            ],
            [
                '',
                '',
                'Network Suffix cannot be empty',
            ],
            [
                'Network中文',
                'Network中文',
                'Invalid Network Suffix',
            ],
            [
                'share',
                'share',
                '',
            ]
        ];
    }
}
