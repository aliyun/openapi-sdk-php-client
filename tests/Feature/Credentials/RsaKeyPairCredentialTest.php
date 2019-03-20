<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class RsaKeyPairCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 */
class RsaKeyPairCredentialTest extends TestCase
{

    /**
     * @var string
     */
    private $clientName = 'RsaKeyPairCredentialTest';

    /**
     * @throws ClientException
     */
    public function setUp()
    {
        parent::setUp();
        $regionId       = 'ap-northeast-1';
        $publicKeyId    = \AlibabaCloud\Client\env('PUBLIC_KEY_ID');
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();
        AlibabaCloud::rsaKeyPairClient($publicKeyId, $privateKeyFile)
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
    public function testGetSessionCredential()
    {
        $credential = AlibabaCloud::get($this->clientName)
                                  ->getSessionCredential(30, 25);
        self::assertInstanceOf(StsCredential::class, $credential);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testEcsInJapan()
    {
        $result = (new DescribeAccessPointsRequest())
            ->client($this->clientName)
            ->connectTimeout(20)
            ->timeout(25)
            ->request();

        $this->assertArrayHasKey('AccessPointSet', $result);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ServerException
     * @expectedExceptionMessageRegExp /InvalidAccessKeyId.NotFound: Specified access key is not found/
     * @throws ClientException
     * @throws ServerException
     */
    public function testEcsNotInJapan()
    {
        // Setup
        $regionId = \AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou');

        // Test
        (new DescribeAccessPointsRequest())
            ->client($this->clientName)
            ->regionId($regionId)
            ->connectTimeout(25)
            ->timeout(30)
            ->request();
    }
}
