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
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class RsaKeyPairCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RsaKeyPairCredentialTest extends TestCase
{

    /**
     * @var string
     */
    private $clientName = 'RsaKeyPairCredentialTest';

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        $regionId       = 'cn-hangzhou';
        $publicKeyId    = \getenv('PUBLIC_KEY_ID');
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();
        AlibabaCloud::rsaKeyPairClient($publicKeyId, $privateKeyFile)
                    ->regionId($regionId)
                    ->name($this->clientName);
    }

    public function testGetSessionCredential()
    {
        try {
            $credential = AlibabaCloud::get($this->clientName)->getSessionCredential();
            self::assertObjectHasAttribute('accessKeyId', $credential);
        } catch (ClientException $e) {
            self::assertEquals(\ALI_INVALID_CREDENTIAL, $e->getErrorCode());
        } catch (Exception $e) {
            self::assertEquals('InvalidAccessKeyId.NotFound', $e->getErrorCode());
        }
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
                                                         ->host('ecs.ap-northeast-1.aliyuncs.com')
                                                         ->connectTimeout(5)
                                                         ->timeout(5)
                                                         ->request();
            $this->assertTrue(isset($result['AccessPointSet']));
        } catch (ClientException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                    \ALI_INVALID_CREDENTIAL,
                    \ALI_CLIENT_NOT_FOUND,
                ]
            );
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Specified access key is not found.',
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
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                    \ALI_INVALID_CREDENTIAL,
                    \ALI_CLIENT_NOT_FOUND,
                ]
            );
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Specified access key is not found.',
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
            $result = (new DescribeCdnServiceRequest())->client($this->clientName)
                                                       ->request();
            $this->assertTrue(isset($result['Regions']));
        } catch (ClientException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                    \ALI_INVALID_CREDENTIAL,
                    \ALI_CLIENT_NOT_FOUND,
                ]
            );
        } catch (ServerException $e) {
            $this->assertContains(
                $e->getErrorCode(),
                [
                    'InvalidAccessKeyId.NotFound',
                    'OperationDenied',
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
            $request = new DescribeRulesRequest();
            $request->setLoadBalancerId(\time());
            $request->setListenerPort(55656);
            $request->client($this->clientName)
                    ->request();
        } catch (ClientException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                    \ALI_INVALID_CREDENTIAL,
                    \ALI_CLIENT_NOT_FOUND,
                ]
            );
        } catch (ServerException $e) {
            $this->assertContains(
                $e->getErrorCode(),
                [
                    'InvalidLoadBalancerId.NotFound',
                    'InvalidAccessKeyId.NotFound',
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
            (new ListAccessKeysRequest())->client($this->clientName)
                                         ->setUserName(\time())
                                         ->request();
        } catch (ClientException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                    \ALI_INVALID_CREDENTIAL,
                    \ALI_CLIENT_NOT_FOUND,
                ]
            );
        } catch (ServerException $e) {
            $this->assertContains(
                $e->getErrorCode(),
                [
                    'InvalidAccessKeyId.NotFound',
                    'EntityNotExist.User',
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
            $result = (new DescribeVpcsRequest())->client($this->clientName)
                                                 ->request();

            $this->assertArrayHasKey('Vpcs', $result);
        } catch (ClientException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
                    \ALI_SERVER_UNREACHABLE,
                    \ALI_INVALID_CREDENTIAL,
                    \ALI_CLIENT_NOT_FOUND,
                ]
            );
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Specified access key is not found.',
                ]
            );
        }
    }
}
