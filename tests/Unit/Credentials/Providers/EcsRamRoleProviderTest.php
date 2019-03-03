<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionException;

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
     *
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Timeout or instance does not belong to Alibaba Cloud
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
     * @throws ReflectionException
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
     * @throws ClientException
     */
    public function testServerUnreachable()
    {
        // Setup
        $roleName = 'EcsRamRoleTest';
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
        $roleName = 'EcsRamRoleTest';
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

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testOk()
    {
        $mock = new MockHandler([
                                    new Response(200, ['X-Foo' => 'Bar'], '{
  "AccessKeyId" : "STS.*******",
  "AccessKeySecret" : "*******",
  "Expiration" : "2019-01-28T15:15:56Z",
  "SecurityToken" : "****",
  "LastUpdated" : "2019-01-28T09:15:55Z",
  "Code" : "Success"
}'),
                                ]);

        EcsRamRoleProvider::$config = ['handler' => HandlerStack::create($mock)];
        $provider                   = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
        $credential                 = $provider->get();
        self::assertInstanceOf(StsCredential::class, $credential);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ServerException
     * @expectedExceptionMessage SDK.InvalidCredential: Result contains no credentials RequestId:
     * @throws ClientException
     * @throws ServerException
     */
    public function testNoCredentials()
    {
        $mock = new MockHandler([
                                    new Response(200),
                                ]);

        EcsRamRoleProvider::$config = ['handler' => HandlerStack::create($mock)];
        $provider                   = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
        $provider->get();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage The role was not found in the instance
     * @throws ClientException
     * @throws ServerException
     */
    public function test404()
    {
        $mock = new MockHandler([
                                    new Response(404),
                                ]);

        EcsRamRoleProvider::$config = ['handler' => HandlerStack::create($mock)];
        $provider                   = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
        $provider->get();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ServerException
     * @expectedExceptionMessage SDK.InvalidCredential: Error retrieving credentials from result RequestId:
     * @throws ClientException
     * @throws ServerException
     */
    public function testErrorRetrieving()
    {
        $mock = new MockHandler([
                                    new Response(500),
                                ]);

        EcsRamRoleProvider::$config = ['handler' => HandlerStack::create($mock)];
        $provider                   = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
        $provider->get();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Error
     * @throws ClientException
     * @throws ServerException
     */
    public function testRequestException()
    {
        $mock = new MockHandler([
                                    new RequestException('Error', new Request('GET', 'test')),
                                ]);

        EcsRamRoleProvider::$config = ['handler' => HandlerStack::create($mock)];
        $provider                   = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
        $provider->get();
    }

    protected function tearDown()
    {
        parent::tearDown();
        EcsRamRoleProvider::$config = [];
    }
}
