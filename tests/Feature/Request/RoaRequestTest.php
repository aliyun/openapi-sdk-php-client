<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
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
            )->asGlobalClient()->regionId('cn-hangzhou');

            $result = AlibabaCloud::roaRequest()
                                  ->pathPattern('/clusters/[ClusterId]/services')
                                  ->method('GET')
                                  ->product('CS')
                                  ->version('2015-12-15')
                                  ->action('DescribeClusterServices')
                                  ->pathParameter('ClusterId', $clusterId)
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
                          ->connectTimeout(15)
                          ->timeout(20)
                          ->request();
        self::assertEquals('Iphone', $result['data'][0]['word']);
    }
}
