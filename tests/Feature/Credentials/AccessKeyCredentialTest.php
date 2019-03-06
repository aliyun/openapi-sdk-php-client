<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Dds\DescribeRegionsRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;
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
     * @throws ClientException
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
     * @throws ClientException
     */
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::del($this->clientName);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testEcs()
    {
        $result = (new DescribeAccessPointsRequest())
            ->client($this->clientName)
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        $this->assertArrayHasKey('AccessPointSet', $result);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testDds()
    {
        $result = (new DescribeRegionsRequest())
            ->client($this->clientName)
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        $this->assertArrayHasKey('Regions', $result);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testCdn()
    {
        $result = (new DescribeCdnServiceRequest())
            ->client($this->clientName)
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        $this->assertArrayHasKey('ChangingChargeType', $result);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testVpc()
    {
        $result = (new DescribeVpcsRequest())
            ->client($this->clientName)
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        $this->assertArrayHasKey('Vpcs', $result);
    }
}
