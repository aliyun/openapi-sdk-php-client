<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use PHPUnit\Framework\TestCase;

/**
 * Class HistoryTraitTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Traits
 */
class HistoryTraitTest extends TestCase
{

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testCountHistory()
    {
        AlibabaCloud::cancelMock();
        AlibabaCloud::forgetHistory();
        AlibabaCloud::rememberHistory();
        $header = ['X-Foo' => 'Bar'];
        $body   = [
            'Code'    => 'code',
            'Message' => 'message',
        ];

        AlibabaCloud::mockResponse(200, $header, $body);
        AlibabaCloud::mockResponse(200, $header, $body);

        AlibabaCloud::rpc()
                    ->product('ecs')
                    ->regionId('cn-hangzhou')
                    ->request();

        AlibabaCloud::rpc()
                    ->product('ecs')
                    ->regionId('cn-hangzhou')
                    ->request();
        self::assertCount(2, AlibabaCloud::getHistory());
        self::assertEquals(2, AlibabaCloud::countHistory());
    }

    /**
     * @depends testCountHistory
     */
    public function testFlushHistory()
    {
        AlibabaCloud::forgetHistory();
        self::assertCount(0, AlibabaCloud::getHistory());
        self::assertEquals(0, AlibabaCloud::countHistory());
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testNotRememberHistory()
    {
        AlibabaCloud::forgetHistory();
        AlibabaCloud::notRememberHistory();
        $header = ['X-Foo' => 'Bar'];
        $body   = [
            'Code'    => 'code',
            'Message' => 'message',
        ];

        AlibabaCloud::mockResponse(200, $header, $body);
        AlibabaCloud::mockResponse(200, $header, $body);

        AlibabaCloud::rpc()
                    ->product('ecs')
                    ->regionId('cn-hangzhou')
                    ->request();

        AlibabaCloud::rpc()
                    ->product('ecs')
                    ->regionId('cn-hangzhou')
                    ->request();
        self::assertCount(0, AlibabaCloud::getHistory());
        self::assertEquals(0, AlibabaCloud::countHistory());
    }
}
