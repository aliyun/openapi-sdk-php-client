<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Dds\DescribeRegionsRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ram\ListAccessKeysRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Slb\DescribeRulesRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Vpc\DescribeVpcsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class AccessKeyCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 */
class AccessKeyCredentialTest extends TestCase
{

    /**
     * @var string
     */
    private $clientName = 'AccessKeyCredentialTest';

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                    ->regionId($regionId)
                    ->name($this->clientName);
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::del($this->clientName);
    }

    /**
     * Assert for Ecs
     */
    public function testEcs()
    {
        try {
            $result = (new DescribeAccessPointsRequest())->client($this->clientName)
                                                         ->connectTimeout(5)
                                                         ->timeout(5)
                                                         ->request();
            $this->assertTrue(isset($result['AccessPointSet']));
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     * Assert for Dds
     */
    public function testDds()
    {
        try {
            $result = (new DescribeRegionsRequest())->client($this->clientName)
                                                    ->request();
            $this->assertTrue(isset($result['Regions']));
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     * Assert for Cdn
     */
    public function testCdn()
    {
        try {
            $result = (new DescribeCdnServiceRequest())->client($this->clientName)
                                                       ->request();
            $this->assertTrue(isset($result['ChangingChargeType']));
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals(
                'OperationDenied',
                $e->getErrorCode()
            );
        }
    }

    /**
     * Assert for Slb
     */
    public function testSlb()
    {
        // Setup
        $clusterId = \time();

        try {
            $request = new DescribeRulesRequest();
            $request->withLoadBalancerId($clusterId);
            $request->withListenerPort(55656);
            $request->client($this->clientName)
                    ->request();
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals(
                'InvalidLoadBalancerId.NotFound',
                $e->getErrorCode()
            );
        }
    }

    /**
     * Assert for Ram
     */
    public function testRam()
    {
        // Setup
        $userName = \time();

        try {
            (new ListAccessKeysRequest())->client($this->clientName)
                                         ->withUserName($userName)
                                         ->request();
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals(
                'EntityNotExist.User',
                $e->getErrorCode()
            );
        }
    }

    /**
     * Assert for Vpc
     *
     * @throws ServerException
     */
    public function testVpc()
    {
        try {
            $result = (new DescribeVpcsRequest())->client($this->clientName)
                                                 ->request();

            $this->assertArrayHasKey('Vpcs', $result);
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }
}
