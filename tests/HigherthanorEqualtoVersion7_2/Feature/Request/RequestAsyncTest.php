<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Result\Result;
use Exception;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use AlibabaCloud\Client\Support\Stringy;

/**
 * Class RequestAsyncTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Request
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
                self::assertArrayHasKey('Code', $result);
                self::assertEquals(
                    'Forbidden.RAM',
                    $result['Code']
                );

                self::assertNotEmpty(
                    403,
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
                self::assertTrue(Stringy::contains($e->getMessage(), 'cURL error'));
            }
        )->wait();
    }
}
