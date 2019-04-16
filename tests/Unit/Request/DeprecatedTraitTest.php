<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class DeprecatedTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 */
class DeprecatedTraitTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testGetDomainParameter()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals([], isset($request->options['form_params']) ? $request->options['form_params'] : []);
    }

    /**
     * @throws ClientException
     */
    public function testGetLocationEndpointType()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals('openAPI', $request->endpointType);
        $endpointType = 'test';

        // Test
        $request->endpointType = $endpointType;

        // Assert
        self::assertEquals($endpointType, $request->endpointType);
    }

    /**
     * @throws ClientException
     */
    public function testGetLocationServiceCode()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals(null, $request->serviceCode);
        $content = 'test';

        // Test
        $request->serviceCode = $content;

        // Assert
        self::assertEquals($content, $request->serviceCode);
    }

    /**
     * @dataProvider getPostHttpBodyData
     *
     * @param array  $array
     * @param string $expected
     */
    public function testGetPostHttpBody(array $array, $expected)
    {
        // Assert
        self::assertEquals(
            $expected,
            RpcRequest::getPostHttpBody($array)
        );
    }

    /**
     * @return array
     */
    public function getPostHttpBodyData()
    {
        return [
            [
                [1, 2, 3],
                '0=1&1=2&2=3',
            ],
            [
                [
                    'a' => 'a',
                    'b' => 'b',
                    'c' => 'c',
                ],
                'a=a&b=b&c=c',
            ],
            [
                [
                    'a' => 'a',
                    'b' => 'b',
                    3,
                    4,
                ],
                'a=a&b=b&0=3&1=4',
            ],
        ];
    }
}
