<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class DeprecatedTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 */
class DeprecatedTraitTest extends TestCase
{
    public function testGetContent()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals(null, $request->getContent());
        $content = 'test';

        // Test
        $request->setContent($content);

        // Assert
        self::assertEquals($content, $request->getContent());
    }

    public function testGetMethod()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals('GET', $request->getMethod());
        $content = 'test';

        // Test
        $request->setMethod($content);

        // Assert
        self::assertEquals(\strtoupper($content), $request->getMethod());
    }

    public function testGetProtocolType()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals('http', $request->getProtocol());
        self::assertEquals('http', $request->getProtocolType());
        $value = 'test';

        // Test
        $request->setProtocol($value);
        $request->setProtocolType($value);

        // Assert
        self::assertEquals($value, $request->getProtocol());
        self::assertEquals($value, $request->getProtocolType());
    }

    public function testGetHeaders()
    {
        // Setup
        $request = new RpcRequest();

        $value = 'test';

        // Test
        $request->addHeader('key', $value);

        // Assert
        self::assertArrayHasKey('key', $request->getHeaders());
    }

    public function testGetQueryParameters()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals([], $request->getQueryParameters());
        $value = 'test';

        // Test
        $request->setQueryParameters('key', $value);

        // Assert
        self::assertArrayHasKey('key', $request->getQueryParameters());
    }

    public function testGetDomainParameter()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals([], $request->getDomainParameter());
        $value = 'test';

        // Test
        $request->putDomainParameters('key', $value);

        // Assert
        self::assertArrayHasKey('key', $request->getDomainParameter());
    }

    public function testGetActionName()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals(null, $request->getActionName());
        $content = 'test';

        // Test
        $request->setActionName($content);

        // Assert
        self::assertEquals($content, $request->getActionName());
    }

    public function testGetAcceptFormat()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals('JSON', $request->getAcceptFormat());
        $content = 'test';

        // Test
        $request->setAcceptFormat($content);

        // Assert
        self::assertEquals(\strtoupper($content), $request->getAcceptFormat());
    }

    public function testGetLocationEndpointType()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals('openAPI', $request->getLocationEndpointType());
        $endpointType = 'test';

        // Test
        $request->endpointType = $endpointType;

        // Assert
        self::assertEquals($endpointType, $request->getLocationEndpointType());
    }

    public function testGetLocationServiceCode()
    {
        // Setup
        $request = new RpcRequest();

        // Assert
        self::assertEquals(null, $request->getLocationServiceCode());
        $content = 'test';

        // Test
        $request->serviceCode = $content;

        // Assert
        self::assertEquals($content, $request->getLocationServiceCode());
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
