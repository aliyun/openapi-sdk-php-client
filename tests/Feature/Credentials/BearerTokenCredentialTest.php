<?php

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
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
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
                                                      ->withInstanceId(\getenv('CC_INSTANCE_ID'))
                                                      ->withOutboundOnly(true)
                                                      ->scheme('https')
                                                      ->host('ccc.cn-shanghai.aliyuncs.com');
            $result  = $request->request();
            self::assertArrayHasKey('PhoneNumbers', $result);
        } catch (ClientException $e) {
            $this->assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorCode(),
                [
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
            (new DescribeAccessPointsRequest())
                ->client($this->clientName)
                ->connectTimeout(10)
                ->timeout(15)
                ->request();
        } catch (ClientException $e) {
            self::assertEquals(
                \ALIBABA_CLOUD_INVALID_REGION_ID,
                $e->getErrorCode()
            );
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
            $this->assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
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
            $this->assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
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
            $this->assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
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
            $this->assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
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
            $this->assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }
    }
}
