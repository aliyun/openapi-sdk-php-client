<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
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
        self::assertInstanceOf(AccessKeyCredential::class, $actual);
    }
}
