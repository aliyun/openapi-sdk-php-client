<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

/**
 * Class MockTraitTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Traits
 */
class MockTraitTest extends TestCase
{
    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function testMock()
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage("Mock queue is empty");
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
        } catch (ServerException $exception) {
            self::assertEquals('message', $exception->getErrorMessage());
            self::assertEquals($body, $exception->getResult()->toArray());
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
