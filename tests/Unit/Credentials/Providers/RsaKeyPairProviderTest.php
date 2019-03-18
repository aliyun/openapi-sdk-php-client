<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Mock;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class RsaKeyPairProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Providers
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider
 */
class RsaKeyPairProviderTest extends TestCase
{

    /**
     * @throws                         ClientException
     * @throws                         ServerException
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /openssl_sign/
     */
    public function testGet()
    {
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
            'Expiration'             => '2020-02-02 11:11:11',
            'SessionAccessKeyId'     => 'foo',
            'SessionAccessKeySecret' => 'bar',
        ];
        $cacheMethod->invokeArgs($provider, [$result]);

        $actual = $provider->get();

        // Assert
        self::assertInstanceOf(StsCredential::class, $actual);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ServerException
     * @expectedExceptionMessage SDK.InvalidCredential: Result contains no credentials RequestId:
     * @throws ClientException
     * @throws ServerException
     */
    public function testNoCredentials()
    {
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

    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::cancelMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::cancelMock();
    }
}
