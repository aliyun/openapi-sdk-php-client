<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\Request\RoaRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class DeprecatedRoaTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 */
class DeprecatedRoaTraitTest extends TestCase
{
    public function testGetUriPattern()
    {
        // Setup
        $request = new RoaRequest();

        // Assert
        self::assertEquals('/', $request->pathPattern);
        self::assertEquals('/', $request->getUriPattern());

        // Setup
        $clientName = __METHOD__;

        // Test
        $request->client($clientName)
                ->setUriPattern('/setUriPattern');

        // Assert
        self::assertEquals('/setUriPattern', $request->pathPattern);
        self::assertEquals('/setUriPattern', $request->getUriPattern());
    }

    public function testGetPathParameters()
    {
        // Setup
        $request = new RoaRequest();

        // Assert
        self::assertEquals([], $request->pathParameters);
        self::assertEquals([], $request->getPathParameters());

        // Setup
        $clientName = __METHOD__;

        // Test
        $request->client($clientName)
                ->putPathParameter('putPathParameter', 'putPathParameter');

        // Assert
        self::assertEquals('putPathParameter', $request->pathParameters['putPathParameter']);
        self::assertEquals('putPathParameter', $request->getPathParameters()['putPathParameter']);
    }
}
