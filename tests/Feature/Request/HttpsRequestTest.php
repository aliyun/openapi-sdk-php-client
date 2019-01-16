<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use PHPUnit\Framework\TestCase;

/**
 * Class HttpsRequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class HttpsRequestTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testHttps()
    {
        AlibabaCloud::bearerTokenClient(
            \getenv('BEARER_TOKEN')
        )->name('ccc')->regionId('cn-shanghai');

        $request = AlibabaCloud::rpcRequest()
                               ->product('CCC')
                               ->version('2017-07-05')
                               ->action('ListPhoneNumbers')
                               ->method('POST')
                               ->serviceCode('ccc')
                               ->client('ccc')
                               ->options([
                                             'verify' => false,
                                             'query'  => [
                                                 'InstanceId'   => \getenv('CCC_INSTANCE_ID'),
                                                 'OutboundOnly' => true,
                                             ],
                                         ])
                               ->scheme('https')
                               ->connectTimeout(15)
                               ->timeout(20)
                               ->host('ccc.cn-shanghai.aliyuncs.com');

        try {
            $request->request();
        } catch (ServerException $e) {
            self::assertEquals(
                'InvalidBearerTokenException: Bearertoken has expired',
                $e->getErrorMessage()
            );
        }
    }
}
