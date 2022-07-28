<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Providers;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Tests\Mock\Mock;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

/**
 * Class RsaKeyPairProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Providers
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider
 */
class RsaKeyPairProviderTest extends TestCase
{

    /**
     * @throws                         ClientException
     * @throws                         ServerException
     */
    public function testGet()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessageMatches("/openssl_sign/");
        // Setup
        $client   = new RsaKeyPairClient(
            'foo',
            VirtualRsaKeyPairCredential::ok()
        );
        $provider = new RsaKeyPairProvider($client);

        // Test
        $actual = $provider->get();

        // Assert
        self::assertInstanceOf(AccessKeyCredential::class, $actual);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     * @throws \ReflectionException
     */
    public function testGetInCache()
    {
        // Setup
        $client   = new RsaKeyPairClient(
            'foo',
            VirtualRsaKeyPairCredential::ok()
        );
        $provider = new RsaKeyPairProvider($client);

        // Test
        $cacheMethod = new \ReflectionMethod(
            RsaKeyPairProvider::class,
            'cache'
        );
        $cacheMethod->setAccessible(true);
        $result = [
            'Expiration'             => '2049-10-01 11:11:11',
            'SessionAccessKeyId'     => 'foo',
            'SessionAccessKeySecret' => 'bar',
        ];
        $cacheMethod->invokeArgs($provider, [$result]);

        $actual = $provider->get();

        // Assert
        self::assertInstanceOf(StsCredential::class, $actual);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testNoCredentials()
    {
        $this->expectException(ServerException::class);
        $this->expectExceptionMessage("SDK.InvalidCredential: Result contains no credentials RequestId:");
        AlibabaCloud::mockResponse();

        $client = AlibabaCloud::rsaKeyPairClient(
            'publicKeyId',
            VirtualRsaKeyPairCredential::privateKeyFileUrl()
        );

        $provider = new RsaKeyPairProvider($client);
        $provider->get();
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testSuccess()
    {
        AlibabaCloud::mockResponse(
            200,
            [],
            '{
    "RequestId": "F702286E-F231-4F40-BB86-XXXXXX",
    "SessionAccessKey": {
        "SessionAccessKeyId": "TMPSK.**************",
        "Expiration": "2019-02-19T07:02:36.225Z",
        "SessionAccessKeySecret": "**************"
    }
}'
        );

        $client = AlibabaCloud::rsaKeyPairClient(
            'public_key_id',
            VirtualRsaKeyPairCredential::privateKeyFileUrl()
        );

        $provider   = new RsaKeyPairProvider($client);
        $credential = $provider->get();

        self::assertInstanceOf(StsCredential::class, $credential);
    }

    protected function setUp(): void
    {
        AlibabaCloud::cancelMock();
    }

    protected function tearDown(): void
    {
        AlibabaCloud::cancelMock();
    }
}
