<?php

namespace AlibabaCloud\Client\Tests\Feature\Product;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

class RamTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function setUp()
    {
        parent::setUp();

        AlibabaCloud::accessKeyClient(\getenv('ACCESS_KEY_ID'), \getenv('ACCESS_KEY_SECRET'))
                    ->asDefaultClient();
    }

    /**
     * @throws ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testRamByCore()
    {
        $result = AlibabaCloud::rpc()
                              ->product('ram')
                              ->version('2015-05-01')
                              ->method('POST')
                              ->action('ListAccessKeys')
                              ->scheme('https')
                              ->connectTimeout(25)
                              ->timeout(30)
                              ->request();
        self::assertTrue(isset($result['AccessKeys']));
    }
}
