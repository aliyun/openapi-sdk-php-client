<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestDebugTest
 *
 * @package AlibabaCloud\Client\Tests\Feature\Request
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
        $regionId        = \getenv('REGION_ID');
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        putenv('DEBUG=sdk');

        // Test
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($nameClient);

        // Assert
        $request = (new DescribeRegionsRequest())->client($nameClient)
                                                 ->connectTimeout(15)
                                                 ->timeout(20);
        $request->request();

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
        $regionId        = \getenv('REGION_ID');
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
                                                 ->connectTimeout(15)
                                                 ->timeout(20);
        $request->request();

        self::assertArrayHasKey('debug', $request->options);
        self::assertTrue($request->options['debug']);
    }
}
