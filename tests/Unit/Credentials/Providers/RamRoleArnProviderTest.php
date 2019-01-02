<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use PHPUnit\Framework\TestCase;

/**
 * Class RamRoleArnProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Providers
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider
 */
class RamRoleArnProviderTest extends TestCase
{
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
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        } catch (ServerException $e) {
            self::assertEquals('InvalidAccessKeyId.NotFound', $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     * @throws ServerException
     * @throws \ReflectionException
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
}
