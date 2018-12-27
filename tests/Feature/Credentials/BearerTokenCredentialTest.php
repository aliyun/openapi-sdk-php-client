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
use AlibabaCloud\Client\Tests\Mock\Services\CCC\ListPhoneNumbersRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Dds\DescribeRegionsRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ram\ListAccessKeysRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Slb\DescribeRulesRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Vpc\DescribeVpcsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class BearerTokenCredentialTest
 *
 * @package      AlibabaCloud\Client\Tests\Feature\Credentials
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 */
class BearerTokenCredentialTest extends TestCase
{

    /**
     * @var string
     */
    protected $clientName = 'BearerTokenCredentialTest';

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        $regionId    = 'cn-hangzhou';
        $bearerToken = \getenv('BEARER_TOKEN');
        AlibabaCloud::bearerTokenClient($bearerToken)
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
     * Assert for CCC
     */
    public function testCCC()
    {
        try {
            $request = (new ListPhoneNumbersRequest())->client($this->clientName)
                                                      ->setInstanceId(\getenv('CC_INSTANCE_ID'))
                                                      ->setOutboundOnly(true)
                                                      ->scheme('https')
                                                      ->host('ccc.cn-shanghai.aliyuncs.com');
            $result  = $request->request();
            self::assertArrayHasKey('PhoneNumbers', $result);
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
                    'InvalidBearerToken.NotFound',
                    'InvalidBearerToken.Inactive',
                    'NotExist.Instance',
                ]
            );
        }
    }

    /**
     * Assert for Ecs
     */
    public function testEcs()
    {
        try {
            (new DescribeAccessPointsRequest())->client($this->clientName)->request();
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }

    /**
     * Assert for Dds
     */
    public function testDds()
    {
        try {
            (new DescribeRegionsRequest())->client($this->clientName)->request();
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }

    /**
     * Assert for Cdn
     */
    public function testCdn()
    {
        try {
            (new DescribeCdnServiceRequest())->client($this->clientName)->request();
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }

    /**
     * Assert for Slb
     */
    public function testSlb()
    {
        try {
            (new DescribeRulesRequest())->client($this->clientName)->request();
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }

    /**
     * Assert for Ram
     */
    public function testRam()
    {
        try {
            (new ListAccessKeysRequest())->client($this->clientName)->request();
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }

    /**
     * Assert for Vpc
     */
    public function testVpc()
    {
        try {
            (new DescribeVpcsRequest())->client($this->clientName)->request();
        } catch (ClientException $e) {
            $this->assertEquals(\ALI_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }
}
