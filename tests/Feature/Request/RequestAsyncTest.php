<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use Exception;
use Stringy\Stringy;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class RequestAsyncTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class RequestAsyncTest extends TestCase
{

    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testRpAsync()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asDefaultClient()->regionId('cn-hangzhou');

        $promise = AlibabaCloud::rpc()
                               ->method('POST')
                               ->product('Cdn')
                               ->version('2014-11-11')
                               ->action('DescribeCdnService')
                               ->connectTimeout(25)
                               ->timeout(30)
                               ->requestAsync();

        $promise->then(
            static function (ResponseInterface $res) {
                self::assertNotEmpty(
                    200,
                    $res->getStatusCode()
                );

                return $res;
            },
            static function (RequestException $e) {
                self::assertEquals(
                    'POST',
                    $e->getRequest()->getMethod()
                );
            }
        )->wait();
    }

    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testRpAsyncTimeout()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asDefaultClient()->regionId('cn-hangzhou');

        $promise = AlibabaCloud::rpc()
                               ->method('POST')
                               ->product('Cdn')
                               ->version('2014-11-11')
                               ->action('DescribeCdnService')
                               ->connectTimeout(0.001)
                               ->timeout(30)
                               ->requestAsync();

        $promise->then(
            static function (ResponseInterface $res) {
                self::assertNotEmpty(200, $res->getStatusCode());

                return $res;
            },
            static function (RequestException $e) {
                self::assertTrue(Stringy::create($e->getMessage())->contains('timed'));
            }
        )->wait();
    }
}
