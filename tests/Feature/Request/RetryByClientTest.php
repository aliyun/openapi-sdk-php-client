<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use Exception;
use Stringy\Stringy;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class RetryByClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class RetryByClientTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::forgetHistory();
        AlibabaCloud::rememberHistory();
    }

    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testNoRetry()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asDefaultClient()->regionId('cn-hangzhou');

        try {
            AlibabaCloud::rpc()
                        ->method('POST')
                        ->product('Cdn')
                        ->version('2014-11-11')
                        ->action('DescribeCdnService')
                        ->connectTimeout(0.001)
                        ->timeout(0.001)
                        ->request();
        } catch (Exception $exception) {
            self::assertTrue(Stringy::create($exception->getMessage())->contains('timed'));
            self::assertEquals(1, AlibabaCloud::countHistory());
        }
    }

    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testRetryWithTimeout()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asDefaultClient()->regionId('cn-hangzhou');

        try {
            AlibabaCloud::rpc()
                        ->method('POST')
                        ->product('Cdn')
                        ->version('2014-11-11')
                        ->action('DescribeCdnService')
                        ->connectTimeout(0.001)
                        ->timeout(0.001)
                        ->retryByClient(3, ['timed'])
                        ->request();
        } catch (Exception $exception) {
            self::assertTrue(Stringy::create($exception->getMessage())->contains('timed'));
            self::assertEquals(4, AlibabaCloud::countHistory());
        }
    }
}
