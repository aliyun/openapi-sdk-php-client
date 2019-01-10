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
    public function testRoa()
    {
        // Setup
        $clusterId = \time();

        // Test
        try {
            if (!AlibabaCloud::has(\ALIBABA_CLOUD_GLOBAL_CLIENT)) {
                AlibabaCloud::accessKeyClient(
                    getenv('ACCESS_KEY_ID'),
                    getenv('ACCESS_KEY_SECRET')
                )
                            ->asGlobalClient()
                            ->regionId('cn-hangzhou');
            }

            $result = AlibabaCloud::roaRequest()
                                  ->pathPattern('/clusters/[ClusterId]/services')
                                  ->method('GET')
                                  ->product('CS')
                                  ->version('2015-12-15')
                                  ->action('DescribeClusterServices')
                                  ->pathParameter('ClusterId', $clusterId)
                                  ->request();

            \assertNotEmpty($result->toArray());
        } catch (ClientException $e) {
            self::assertEquals(
                \ALIBABA_CLOUD_SERVER_UNREACHABLE,
                $e->getErrorCode()
            );
        } catch (ServerException $e) {
            self::assertEquals(
                "cluster ($clusterId) not found in our records",
                $e->getErrorMessage()
            );
        }
    }

    public function testRoaContent()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('NLP_ACCESS_KEY_ID'),
            \getenv('NLP_ACCESS_KEY_SECRET')
        )->name('content')
                    ->regionId('cn-shanghai');

        $request = new NlpRequest();
        $request->pathParameter('Domain', 'general');
        $request->jsonBody([
                               'lang' => 'ZH',
                               'text' => 'Iphone专用数据线',
                           ]);

        try {
            $result = $request->client('content')->request();
            self::assertEquals('Iphone', $result['data'][0]['word']);
        } catch (ServerException $e) {
            $this->assertEquals($e->getErrorCode(), 'InvalidApi.NotPurchase');
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error', $e->getErrorMessage());
        }
    }
}
