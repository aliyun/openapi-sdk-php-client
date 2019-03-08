<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

/**
 * Class MockTraitTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Traits
 */
class MockTraitTest extends TestCase
{
    /**
     * @expectedExceptionMessage Mock queue is empty
     * @expectedException OutOfBoundsException
     * @throws ServerException
     * @throws ClientException
     */
    public function testMock()
    {
        AlibabaCloud::cancelMock();

        $header = ['X-Foo' => 'Bar'];
        $body   = [
            'Code'    => 'code',
            'Message' => 'message',
        ];

        AlibabaCloud::mockResponse(200, $header, $body);
        AlibabaCloud::mockResponse(500, $header, $body);

        $result = AlibabaCloud::rpc()
                              ->product('ecs')
                              ->regionId('cn-hangzhou')
                              ->request();

        self::assertEquals($body, $result->toArray());

        try {
            AlibabaCloud::rpc()
                        ->product('ecs')
                        ->regionId('cn-hangzhou')
                        ->request();
        } catch (ServerException $e) {
            self::assertEquals('message', $e->getErrorMessage());
            self::assertEquals($body, $e->getResult()->toArray());
        }

        AlibabaCloud::rpc()
                    ->product('ecs')
                    ->regionId('cn-hangzhou')
                    ->request();
    }

    public function testCancelMock()
    {
        AlibabaCloud::mockResponse();
        AlibabaCloud::mockResponse(500);
        self::assertTrue(AlibabaCloud::hasMock());
        AlibabaCloud::cancelMock();
        self::assertFalse(AlibabaCloud::hasMock());
    }
}
