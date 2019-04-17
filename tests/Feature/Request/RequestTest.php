<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClusterServicesRequest;

/**
 * Class RequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 */
class RequestTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $request->withClusterId($clusterId);

        // Test
        try {
            $request->connectTimeout(25)
                    ->timeout(30)
                    ->request();
        } catch (ServerException $e) {
            // Assert
            self::assertEquals('ErrorClusterNotFound', $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testWithBearerTokenCredential()
    {
        // Setup
        $regionId    = 'cn-hangzhou';
        $bearerToken = 'BEARER_TOKEN';
        AlibabaCloud::bearerTokenClient($bearerToken)
                    ->name('BEARER_TOKEN')
                    ->regionId($regionId);

        // Test
        try {
            (new  DescribeClusterServicesRequest())
                ->client('BEARER_TOKEN')
                ->withClusterId(\time())
                ->connectTimeout(25)
                ->timeout(30)
                ->request();
        } catch (ServerException $e) {
            // Assert
            static::assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testInvalidUrl()
    {
        // Setup
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name(__METHOD__);

        // Test
        try {
            (new  DescribeClusterServicesRequest())
                ->connectTimeout(25)
                ->timeout(30)
                ->client(__METHOD__)
                ->withClusterId(\time())
                ->request();
        } catch (ServerException $e) {
            // Assert
            self::assertEquals('ErrorClusterNotFound', $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testROA()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        $request->withClusterId(\time());

        // Test
        try {
            $request->connectTimeout(25)
                    ->timeout(30)
                    ->request();
            // Assert
        } catch (ServerException $exception) {
            // Assert
            static::assertEquals('ErrorClusterNotFound', $exception->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testAccept()
    {
        // Setup
        $roa = AlibabaCloud::roa();
        $rpc = AlibabaCloud::rpc();

        // Test
        $roa->accept('accept');
        $rpc->accept('accept');

        // Assert
        self::assertEquals('accept', $roa->options['headers']['Accept']);
        self::assertEquals('accept', $rpc->options['headers']['Accept']);
    }

    /**
     * @throws ClientException
     */
    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asDefaultClient()->regionId(\AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou'));
    }
}
