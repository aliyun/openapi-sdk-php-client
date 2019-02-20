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
 * Class EcsRamRoleCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 */
class EcsRamRoleCredentialTest extends TestCase
{

    /**
     * @var string
     */
    private $clientName = 'EcsRamRoleCredentialTest';

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        $regionId = 'cn-hangzhou';
        $roleName = \getenv('ECS_ROLE_NAME');
        AlibabaCloud::ecsRamRoleClient($roleName)
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

    public function testGetSessionCredentialWithTest()
    {
        try {
            (new DescribeRegionsRequest())->client($this->clientName)->request();
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertEquals('Error in retrieving assume role credentials.', $e->getErrorMessage());
        }
    }

    /**
     * Assert for Ecs
     */
    public function testEcs()
    {
        try {
            $result = (new DescribeAccessPointsRequest())->client($this->clientName)->request();
            $this->assertTrue(isset($result['AccessPointSet']));
        } catch (ClientException $e) {
            self::assertEquals(
                \ALIBABA_CLOUD_SERVER_UNREACHABLE,
                $e->getErrorCode()
            );
        } catch (ServerException $e) {
            self::assertEquals(
                'Error in retrieving assume role credentials.',
                $e->getErrorMessage()
            );
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
            // Only ECS instance can get result
            $this->assertTrue(isset($result['Regions']));
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertEquals(
                'Error in retrieving assume role credentials.',
                $e->getErrorMessage()
            );
        }
    }

    /**
     * Assert for Cdn
     */
    public function testCdn()
    {
        try {
            (new DescribeCdnServiceRequest())->client($this->clientName)
                                             ->request();
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals(
                'Forbidden.RAM',
                $e->getErrorCode()
            );
        }
    }

    /**
     * Assert for Slb
     */
    public function testSlb()
    {
        try {
            (new DescribeRulesRequest())
                ->withLoadBalancerId(\time())
                ->withListenerPort(55656)
                ->client($this->clientName)
                ->request();
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
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
        try {
            (new ListAccessKeysRequest())
                ->withUserName(\time())
                ->client($this->clientName)
                ->request();
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
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
     */
    public function testVpc()
    {
        try {
            $result = (new DescribeVpcsRequest())
                ->client($this->clientName)
                ->request();

            $this->assertArrayHasKey('Vpcs', $result);
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertEquals(
                'Error in retrieving assume role credentials.',
                $e->getErrorMessage()
            );
        }
    }
}
