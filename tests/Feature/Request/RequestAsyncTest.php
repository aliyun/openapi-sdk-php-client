<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Result\Result;
use Exception;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Stringy\Stringy;

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
            static function (Result $result) {
                self::assertArrayHasKey('ChangingChargeType', $result);

                self::assertNotEmpty(
                    200,
                    $result->getStatusCode()
                );

                return $result;
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
            static function (Exception $e) {
                self::assertTrue(Stringy::create($e->getMessage())->contains('cURL error'));
            }
        )->wait();
    }
}
