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
 * Class RamRoleArnCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RamRoleArnCredentialTest extends TestCase
{

    /**
     * @var string
     */
    private $clientName = 'RamRoleArnCredentialTest';

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
        $roleArn         = \getenv('ROLE_ARN');
        $roleSessionName = \getenv('ROLE_SESSION_NAME');
        AlibabaCloud::ramRoleArnClient(
            $accessKeyId,
            $accessKeySecret,
            $roleArn,
            $roleSessionName
        )
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
                                                         ->request();
            $this->assertTrue(isset($result['AccessPointSet']));
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                self::assertContains(
                    $e->getErrorMessage(),
                    [
                        'Specified access key is not found.',
                    ]
                );
            } else {
                self::assertContains(
                    $e->getErrorMessage(),
                    [
                        'You are not authorized to do this action. You should be authorized by RAM.',
                    ]
                );
            }
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
            $this->assertTrue(isset($result['Endpoint']));
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                self::assertContains(
                    $e->getErrorMessage(),
                    [
                        'Specified access key is not found.',
                    ]
                );
            } else {
                self::assertContains(
                    $e->getErrorMessage(),
                    [
                        'You are not authorized to do this action. You should be authorized by RAM.',
                    ]
                );
            }
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
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'InvalidAccessKeyId.NotFound',
                    ]
                );
            } else {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'NoPermission',
                        'Forbidden.RAM',
                    ]
                );
            }
        }
    }

    /**
     * Assert for Slb
     */
    public function testSlb()
    {
        try {
            (new DescribeRulesRequest())->client($this->clientName)
                                        ->setLoadBalancerId(\time())
                                        ->setListenerPort(55656)
                                        ->request();
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'InvalidAccessKeyId.NotFound',
                    ]
                );
            } else {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'NoPermission',
                        'InvalidLoadBalancerId.NotFound',
                    ]
                );
            }
        }
    }

    /**
     * Assert for Ram
     */
    public function testRam()
    {
        try {
            (new ListAccessKeysRequest())->client($this->clientName)
                                         ->setUserName(\time())
                                         ->request();
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'InvalidAccessKeyId.NotFound',
                    ]
                );
            } else {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'NoPermission',
                        'EntityNotExist.User',
                    ]
                );
            }
        }
    }

    /**
     * Assert for Vpc
     */
    public function testVpc()
    {
        try {
            $result = (new DescribeVpcsRequest())->client($this->clientName)
                                                 ->request();
            $this->assertArrayHasKey('Vpcs', $result);
        } catch (ClientException $e) {
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            if (\getenv('ACCESS_KEY_ID') === 'foo') {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'InvalidAccessKeyId.NotFound',
                    ]
                );
            } else {
                self::assertContains(
                    $e->getErrorCode(),
                    [
                        'NoPermission',
                        'EntityNotExist.User',
                    ]
                );
            }
        }
    }
}
