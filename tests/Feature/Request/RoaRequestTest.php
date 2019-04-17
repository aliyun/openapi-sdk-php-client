<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\Nlp\NlpRequest;

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
                               'text' => 'Iphone专用数据线'
                           ]);

        $result = $request->client('content')
                          ->connectTimeout(25)
                          ->timeout(30)
                          ->request();
        self::assertEquals('Iphone', $result['data'][0]['word']);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testSearchImage()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('IMAGE_SEARCH_ACCESS_KEY_ID'),
            \getenv('IMAGE_SEARCH_ACCESS_KEY_SECRET')
        )->regionId('cn-shanghai')->name('im');

        $request = AlibabaCloud::roa()
                               ->connectTimeout(40)
                               ->timeout(50)
                               ->client('im')
                               ->product('ImageSearch')
                               ->version('2019-03-25')
                               ->method('POST')
                               ->action('SearchImage')
                               ->pathPattern('/v2/image/search')
                               ->accept('application/json')
                               ->contentType('application/x-www-form-urlencoded; charset=UTF-8');

        $content = file_get_contents(__DIR__ . '/ImageSearch.jpg');

        $result = $request->options([
                                        'form_params' => [
                                            'InstanceName' => getenv('IMAGE_SEARCH_INSTANCE_NAME'),
                                            'PicContent'   => base64_encode($content),
                                            'Start'        => 0,
                                            'Num'          => 10
                                        ]
                                    ])
                          ->request();

        self::assertArrayHasKey('Auctions', $result);
    }
}
