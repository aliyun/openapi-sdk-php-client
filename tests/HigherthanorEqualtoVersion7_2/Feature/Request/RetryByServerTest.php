<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Request;

use Exception;
use AlibabaCloud\Client\Support\Stringy;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class RetryByServerTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Request
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class RetryByServerTest extends TestCase
{
    protected function setUp(): void
    {
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
                        ->action('DescribeCdnServiceNotFound')
                        ->connectTimeout(25)
                        ->timeout(30)
                        ->request();
        } catch (Exception $exception) {
            self::assertFalse(Stringy::contains($exception->getMessage(), 'Action or Version'));
            self::assertEquals(1, AlibabaCloud::countHistory());
        }
    }

    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testRetryWithStrings()
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
                        ->action('DescribeCdnServiceNotFound')
                        ->connectTimeout(25)
                        ->timeout(30)
                        ->retryByServer(3, ['Action or Version'])
                        ->request();
        } catch (Exception $exception) {
            self::assertFalse(Stringy::contains($exception->getMessage(), 'Action or Version'));
            self::assertEquals(1, AlibabaCloud::countHistory());
        }
    }

    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testRetryWithStatusCode()
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
                        ->action('DescribeCdnServiceNotFound')
                        ->connectTimeout(25)
                        ->timeout(30)
                        ->retryByServer(3, [], [404])
                        ->request();
        } catch (Exception $exception) {
            self::assertFalse(Stringy::contains($exception->getMessage(), 'Action or Version'));
            self::assertEquals(4, AlibabaCloud::countHistory());
        }
    }

    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testRetryWithFalse()
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
                        ->action('DescribeCdnServiceNotFound')
                        ->connectTimeout(25)
                        ->timeout(30)
                        ->retryByServer(3, [], [])
                        ->request();
        } catch (Exception $exception) {
            self::assertFalse(Stringy::contains($exception->getMessage(), 'Action or Version'));
            self::assertEquals(1, AlibabaCloud::countHistory());
        }
    }
}
