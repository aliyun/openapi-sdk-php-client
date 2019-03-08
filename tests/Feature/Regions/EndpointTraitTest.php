<?php

namespace AlibabaCloud\Client\Tests\Feature\Regions;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Regions\LocationService;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointTraitTest
 *
 * @package AlibabaCloud\Client\Tests\Feature\Regions
 */
class EndpointTraitTest extends TestCase
{
    /**
     * @return array
     */
    public function products()
    {
        return [
            [
                'Slb',
                'slb',
                [
                    'slb.aliyuncs.com',
                    '',
                ],
            ],
            [
                'Ess',
                'ess',
                [
                    'ess.aliyuncs.com',
                    '',
                ],
            ],
            [
                'EHPC',
                'ehs',
                [
                    'ehpc.cn-hangzhou.aliyuncs.com',
                    '',
                ],
            ],
            [
                'EHPC',
                'badServiceCode',
                [
                    'ehpc.cn-hangzhou.aliyuncs.com',
                    '',
                ],
            ],
            [
                'Slb',
                '',
                [
                    'slb.aliyuncs.com',
                    '',
                ],
            ],
        ];
    }

    /**
     * @dataProvider products
     *
     * @param string $productName
     * @param string $serviceCode
     * @param array  $expectedHost
     *
     * @throws ClientException
     * @throws ServerException
     */
    public function testLocationServiceResolveHost($productName, $serviceCode, array $expectedHost)
    {
        // Setup
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId('cn-hangzhou')
                    ->asDefaultClient();

        // Test
        $request = new RpcRequest();
        $request->connectTimeout(25)->timeout(30);
        $request->product     = $productName;
        $request->serviceCode = $serviceCode;

        // Assert
        $host = LocationService::resolveHost($request);
        self::assertContains($host, $expectedHost);
    }
}
