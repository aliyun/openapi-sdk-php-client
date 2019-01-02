<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use PHPUnit\Framework\TestCase;

/**
 * Class EcsRamRoleProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Providers
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider
 */
class EcsRamRoleProviderTest extends TestCase
{

    /**
     * @throws                         ClientException
     * @throws                         ServerException
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /cURL error/
     */
    public function testGet()
    {
        // Setup
        $client   = new EcsRamRoleClient('foo');
        $provider = new EcsRamRoleProvider($client);

        // Test
        $actual = $provider->get();

        // Assert
        self::assertInstanceOf(StsCredential::class, $actual);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     * @throws \ReflectionException
     */
    public function testGetInCache()
    {
        // Setup
        $client   = new EcsRamRoleClient(
            'foo'
        );
        $provider = new EcsRamRoleProvider($client);

        // Test
        $cacheMethod = new \ReflectionMethod(
            RsaKeyPairProvider::class,
            'cache'
        );
        $cacheMethod->setAccessible(true);
        $result = [
            'Expiration'      => '2020-02-02 11:11:11',
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
     * @throws ServerException
     */
    public function testServerUnreachable()
    {
        // Setup
        $roleName = \getenv('ECS_ROLE_NAME');
        $client   = new EcsRamRoleClient($roleName);

        // Test
        $credential = new EcsRamRoleProvider($client);

        // Assert
        try {
            $credential->get();
        } catch (ClientException $e) {
            $this->assertEquals($e->getErrorCode(), \ALIBABA_CLOUD_SERVER_UNREACHABLE);
        }
    }

    /**
     * @throws ClientException
     */
    public function estInvalidCredential()
    {
        // Setup
        $roleName = \getenv('ECS_ROLE_NAME');
        $client   = new EcsRamRoleClient($roleName);

        // Test
        $provider = new EcsRamRoleProvider($client);

        // Assert
        try {
            $provider->get();
        } catch (ServerException $e) {
            $this->assertEquals(
                $e->getErrorCode(),
                \ALIBABA_CLOUD_INVALID_CREDENTIAL
            );
        }
    }
}
