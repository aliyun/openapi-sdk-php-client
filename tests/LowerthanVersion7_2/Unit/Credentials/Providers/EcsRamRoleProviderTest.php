<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials\Providers;

use ReflectionException;
use AlibabaCloud\Client\SDK;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;

/**
 * Class EcsRamRoleProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials\Providers
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
        AlibabaCloud::mockRequestException('timed', new Request('GET', 'url'));

        // Test
        $provider->get();
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
            $this->assertEquals($e->getErrorCode(), SDK::SERVER_UNREACHABLE);
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
                SDK::INVALID_CREDENTIAL
            );
        }
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
  "AccessKeyId" : "STS.*******",
  "AccessKeySecret" : "*******",
  "Expiration" : "2019-01-28T15:15:56Z",
  "SecurityToken" : "****",
  "LastUpdated" : "2019-01-28T09:15:55Z",
  "Code" : "Success"
}'
        );
        $provider   = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
        $credential = $provider->get();
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
        AlibabaCloud::mockResponse();
        $provider = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
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
        AlibabaCloud::mockResponse(404);
        $provider = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
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
        AlibabaCloud::mockResponse(500);
        $provider = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
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
        AlibabaCloud::mockRequestException('Error', new Request('GET', 'test'));
        $provider = new EcsRamRoleProvider(AlibabaCloud::ecsRamRoleClient('role'));
        $provider->get();
    }

    protected function tearDown()
    {
        AlibabaCloud::cancelMock();
    }
}
