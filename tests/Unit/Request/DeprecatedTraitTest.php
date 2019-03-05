<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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

    /**
     * @throws ClientException
     */
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
