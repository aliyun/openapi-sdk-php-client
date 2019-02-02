<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClusterServicesRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 */
class RequestTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asGlobalClient()->regionId(\getenv('REGION_ID'));
    }

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
            $request->connectTimeout(15)
                    ->timeout(20)
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
                ->connectTimeout(15)
                ->timeout(20)
                ->request();
        } catch (ServerException $e) {
            // Assert
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
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
                ->connectTimeout(15)
                ->timeout(20)
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
            $request->connectTimeout(15)
                    ->timeout(20)
                    ->request();
            // Assert
        } catch (ServerException $e) {
            // Assert
            $this->assertEquals('ErrorClusterNotFound', $e->getErrorCode());
        }
    }
}
