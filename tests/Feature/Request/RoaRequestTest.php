<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Nlp\NlpRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RoaRequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 */
class RoaRequestTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function testRoa()
    {
        // Setup
        $clusterId = \time();

        // Test
        try {
            AlibabaCloud::accessKeyClient(
                getenv('ACCESS_KEY_ID'),
                getenv('ACCESS_KEY_SECRET')
            )->asDefaultClient()->regionId('cn-hangzhou');

            $result = AlibabaCloud::roa()
                                  ->pathPattern('/clusters/[ClusterId]/services')
                                  ->method('GET')
                                  ->product('CS')
                                  ->version('2015-12-15')
                                  ->action('DescribeClusterServices')
                                  ->pathParameter('ClusterId', $clusterId)
                                  ->connectTimeout(25)
                                  ->timeout(30)
                                  ->request();

            self::assertNotEmpty($result->toArray());
        } catch (ServerException $e) {
            self::assertEquals(
                "cluster ($clusterId) not found in our records",
                $e->getErrorMessage()
            );
        }
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testRoaContent()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->name('content')->regionId('cn-shanghai');

        $request = new NlpRequest();
        $request->pathParameter('Domain', 'general');
        $request->jsonBody([
                               'lang' => 'ZH',
                               'text' => 'Iphone专用数据线',
                           ]);

        $result = $request->client('content')
                          ->connectTimeout(25)
                          ->timeout(30)
                          ->request();
        self::assertEquals('Iphone', $result['data'][0]['word']);
    }

    /**
     * @throws ClientException
     */
    public function testCall()
    {
        $request = new RoaRequest();
        self::assertEquals([], $request->pathParameters);

        $request->setPrefix('set');
        self::assertEquals('set', $request->getPrefix());
        self::assertEquals(['Prefix' => 'set',], $request->pathParameters);

        $request->withPrefix('with');
        self::assertEquals('with', $request->getPrefix());
        self::assertEquals(['Prefix' => 'with',], $request->pathParameters);

        $request->setprefix('set');
        self::assertEquals('set', $request->getprefix());
        self::assertEquals(['Prefix' => 'with', 'prefix' => 'set',], $request->pathParameters);

        $request->withprefix('with');
        self::assertEquals('with', $request->getprefix());
        self::assertEquals(['Prefix' => 'with', 'prefix' => 'with',], $request->pathParameters);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Call to undefined method AlibabaCloud\Client\Request\RoaRequest::nowithvalue()
     * @throws ClientException
     */
    public function testCallException()
    {
        $request = new RoaRequest();
        $request->nowithvalue('value');
    }
}
