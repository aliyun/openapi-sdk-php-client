<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

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
 * @package      AlibabaCloud\Client\Tests\Feature\Credentials
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
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
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
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
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                ]
            );
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Error in retrieving assume role credentials.',
                ]
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
            $this->assertTrue(isset($result['Regions']));
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Specified access key is not found.',
                    'Error in retrieving assume role credentials.',
                ]
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
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertContains(
                $e->getErrorCode(),
                [
                    'Forbidden.RAM',
                    'InvalidAccessKeyId.NotFound',
                    \ALI_INVALID_CREDENTIAL,
                ]
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
                ->setLoadBalancerId(\time())
                ->setListenerPort(55656)
                ->client($this->clientName)
                ->request();
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertContains(
                $e->getErrorCode(),
                [
                    'InvalidLoadBalancerId.NotFound',
                    'InvalidAccessKeyId.NotFound',
                    \ALI_INVALID_CREDENTIAL,
                ]
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
                ->setUserName(\time())
                ->client($this->clientName)
                ->request();
        } catch (ClientException $e) {
            // If the request is not from a bound ECS instance.
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertContains(
                $e->getErrorCode(),
                [
                    'EntityNotExist.User',
                    'InvalidAccessKeyId.NotFound',
                    \ALI_INVALID_CREDENTIAL,
                ]
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
            self::assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Specified access key is not found.',
                    'Error in retrieving assume role credentials.',
                ]
            );
        }
    }
}
