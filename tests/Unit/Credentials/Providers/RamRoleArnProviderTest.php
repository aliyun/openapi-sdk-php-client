<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use ReflectionException;
use AlibabaCloud\Client\SDK;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider;

/**
 * Class RamRoleArnProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Providers
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider
 */
class RamRoleArnProviderTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function testGet()
    {
        // Setup
        $client   = new RamRoleArnClient(
            'foo',
            'bar',
            'arn',
            'name'
        );
        $provider = new RamRoleArnProvider($client);

        // Test
        try {
            $actual = $provider->get();
            self::assertInstanceOf(StsCredential::class, $actual);
        } catch (ClientException $e) {
            self::assertEquals(SDK::SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertEquals('InvalidAccessKeyId.NotFound', $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     * @throws ServerException
     * @throws ReflectionException
     */
    public function testGetInCache()
    {
        // Setup
        $client   = new RamRoleArnClient(
            'foo',
            'bar',
            'arn',
            'name'
        );
        $provider = new RamRoleArnProvider($client);

        // Test
        $cacheMethod = new \ReflectionMethod(
            RamRoleArnProvider::class,
            'cache'
        );
        $cacheMethod->setAccessible(true);
        $result = [
            'Expiration'      => '2049-10-01 11:11:11',
            'AccessKeyId'     => 'foo',
            'AccessKeySecret' => 'bar',
            'SecurityToken'   => 'token',
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

        $client = AlibabaCloud::ramRoleArnClient('id', 'secret', 'arn', 'session');

        $provider = new RamRoleArnProvider($client);
        $provider->get();
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testOk()
    {
        AlibabaCloud::mockResponse(
            200,
            [],
            '{
    "RequestId": "88FEA385-EF5D-4A8A-8C00-A07DAE3BFD44",
    "AssumedRoleUser": {
        "AssumedRoleId": "********************",
        "Arn": "********************"
    },
    "Credentials": {
        "AccessKeySecret": "********************",
        "AccessKeyId": "STS.**************",
        "Expiration": "2020-02-25T03:56:19Z",
        "SecurityToken": "**************"
    }
}'
        );

        $client = AlibabaCloud::ramRoleArnClient('id', 'secret', 'arn', 'session');

        $provider   = new RamRoleArnProvider($client);
        $credential = $provider->get();
        self::assertInstanceOf(StsCredential::class, $credential);
    }

    protected function tearDown()
    {
        AlibabaCloud::cancelMock();
    }
}
