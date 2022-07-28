<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

/**
 * Class RsaKeyPairCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Credentials
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
    public function setUp(): void
    {
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
    public function tearDown(): void
    {
        AlibabaCloud::del($this->clientName);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testGetSessionCredential()
    {
        $this->expectException(ServerException::class);
        $this->expectExceptionMessageMatches("/NoPermission: You are not authorized to do this action. You should be authorized by RAM./");
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
        $this->expectException(ServerException::class);
        $this->expectExceptionMessageMatches("/NoPermission: You are not authorized to do this action. You should be authorized by RAM./");
        $result = (new DescribeAccessPointsRequest())
            ->client($this->clientName)
            ->connectTimeout(20)
            ->timeout(25)
            ->request();

        static::assertArrayHasKey('AccessPointSet', $result);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testEcsNotInJapan()
    {
        $this->expectException(ServerException::class);
        $this->expectExceptionMessageMatches("/NoPermission: You are not authorized to do this action. You should be authorized by RAM./");
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
