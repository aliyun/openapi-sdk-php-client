<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\Clients\AccessKeyClient;
use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Clients\StsClient;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\Providers\Provider;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Providers
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider
 */
class ProviderTest extends TestCase
{

    /**
     * @param Client $client
     * @param string $key
     *
     * @throws       \ReflectionException
     * @dataProvider key
     */
    public function testKey(Client $client, $key)
    {
        // Setup
        $provider = new Provider($client);

        // Test
        $method = new \ReflectionMethod(
            Provider::class,
            'key'
        );
        $method->setAccessible(true);
        $actual = $method->invoke($provider);

        // Assert
        self::assertEquals($key, $actual);
    }

    /**
     * @return array
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function key()
    {
        return [
            [
                new AccessKeyClient('foo', 'bar'),
                'foo#bar',
            ],
            [
                new BearerTokenClient('token'),
                'bearerToken#token',
            ],
            [
                new Client(
                    new AccessKeyCredential('foo', 'bar'),
                    new ShaHmac1Signature()
                ),
                'foo#bar',
            ],
            [
                new EcsRamRoleClient('name'),
                'roleName#name',
            ],
            [
                new RamRoleArnClient('foo', 'bar', 'arn', 'name'),
                'foo#bar#arn#name',
            ],
            [
                new RsaKeyPairClient('foo', VirtualRsaKeyPairCredential::ok()),
                'publicKeyId#foo',
            ],
            [
                new StsClient('foo', 'bar', 'token'),
                'foo#bar#token',
            ],
        ];
    }

    /**
     * @param Client $client
     * @param array  $result
     *
     * @throws       \ReflectionException
     * @dataProvider cache
     */
    public function testCache(Client $client, array $result)
    {
        // Setup
        $provider = new Provider($client);

        // Test
        $cacheMethod = new \ReflectionMethod(
            Provider::class,
            'cache'
        );
        $cacheMethod->setAccessible(true);
        $cacheMethod->invokeArgs($provider, [$result]);

        $keyMethod = new \ReflectionMethod(
            Provider::class,
            'key'
        );
        $keyMethod->setAccessible(true);
        $key = $keyMethod->invoke($provider);

        $property = new \ReflectionProperty(
            Provider::class,
            'credentialsCache'
        );
        $property->setAccessible(true);
        $actual = $property->getValue();

        // Assert
        self::assertEquals($result, $actual[$key]);
    }

    /**
     * @param Client     $client
     * @param array      $credential
     * @param array|null $result
     *
     * @throws       \ReflectionException
     * @dataProvider cache
     */
    public function testGetCredentialsInCache(Client $client, array $credential, $result)
    {
        // Setup
        $provider = new Provider($client);

        // Test
        $cacheMethod = new \ReflectionMethod(
            Provider::class,
            'cache'
        );
        $cacheMethod->setAccessible(true);
        $cacheMethod->invokeArgs($provider, [$credential]);

        $cacheResult = $provider->getCredentialsInCache();

        // Assert
        self::assertEquals($cacheResult, $result);
    }

    /**
     * @return array
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function cache()
    {
        return [
            [
                new AccessKeyClient('foo', 'bar'),
                [
                    'Expiration' => '2020-02-02 11:11:11',
                ],
                [
                    'Expiration' => '2020-02-02 11:11:11',
                ],
            ],
            [
                new BearerTokenClient('token'),
                [
                    'Expiration' => \date('Y-m-d H:i:s', \time() + 4),
                ],
                null,
            ],
            [
                new Client(
                    new AccessKeyCredential('foo', 'bar'),
                    new ShaHmac1Signature()
                ),
                [
                    'Expiration' => '2017-02-02 11:11:11',
                ],
                null,
            ],
            [
                new EcsRamRoleClient('name'),
                [
                    'Expiration' => '2017-02-02 11:11:11',
                ],
                null,
            ],
            [
                new RamRoleArnClient('foo', 'bar', 'arn', 'name'),
                [
                    'Expiration' => '2017-02-02 11:11:11',
                ],
                null,
            ],
            [
                new RsaKeyPairClient('foo', VirtualRsaKeyPairCredential::ok()),
                [
                    'Expiration' => '2017-02-02 11:11:11',
                ],
                null,
            ],
            [
                new StsClient('foo', 'bar', 'token'),
                [
                    'Expiration' => '2017-02-02 11:11:11',
                ],
                null,
            ],
        ];
    }
}
