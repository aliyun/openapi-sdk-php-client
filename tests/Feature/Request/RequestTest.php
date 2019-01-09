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
        )->asGlobalClient()
                    ->regionId('cn-hangzhou');
    }

    public function testConstruct()
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $request->withClusterId($clusterId);

        // Test
        try {
            $request->request();
            // Assert
        } catch (ServerException $e) {
            // Assert
            self::assertEquals('ErrorClusterNotFound', $e->getErrorCode());
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

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
            (new  DescribeClusterServicesRequest())->client('BEARER_TOKEN')
                                                   ->withClusterId(\time())
                                                   ->request();
        } catch (ServerException $e) {
            // Assert
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

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
            (new  DescribeClusterServicesRequest())->client(__METHOD__)
                                                   ->withClusterId(\time())
                                                   ->request();
        } catch (ServerException $e) {
            // Assert
            $this->assertEquals('ErrorClusterNotFound', $e->getErrorCode());
        } catch (ClientException $e) {
            // Assert
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     */
    public function testROA()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        $request->withClusterId(\time());

        // Test
        try {
            $request->request();
            // Assert
        } catch (ServerException $e) {
            // Assert
            $this->assertEquals($e->getErrorCode(), 'ErrorClusterNotFound');
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }
}
