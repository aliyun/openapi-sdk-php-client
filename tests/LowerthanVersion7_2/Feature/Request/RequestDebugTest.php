<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Feature\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;

/**
 * Class RequestDebugTest
 *
 * @package AlibabaCloud\Client\Tests\LowerthanVersion7_2\Feature\Request
 */
class RequestDebugTest extends TestCase
{
    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testEnv()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        putenv('DEBUG=sdk');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        $request = (new DescribeRegionsRequest())->client($nameClient)
                                                 ->connectTimeout(25)
                                                 ->timeout(30);
        $request->request();

        // Assert
        self::assertArrayHasKey('debug', $request->options);
        self::assertTrue($request->options['debug']);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testOption()
    {
        // Setup
        $nameClient      = 'name';
        $regionId        = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        putenv('DEBUG=false');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Assert
        $request = (new DescribeRegionsRequest())->client($nameClient)
                                                 ->debug(true)
                                                 ->connectTimeout(25)
                                                 ->timeout(30);
        $request->request();

        self::assertArrayHasKey('debug', $request->options);
        self::assertTrue($request->options['debug']);
    }
}
