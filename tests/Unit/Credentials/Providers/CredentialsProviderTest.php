<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;

/**
 * Class CredentialsProviderTest
 *
 * @package AlibabaCloud\Client\Tests\Feature\Credentials\Providers
 */
class CredentialsProviderTest extends TestCase
{
    /**
     * @expectedExceptionMessage Environment variable 'ALIBABA_CLOUD_ACCESS_KEY_ID' cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testEnvironmentVariableIdEmpty()
    {
        putenv('ALIBABA_CLOUD_ACCESS_KEY_ID=');
        $provider = CredentialsProvider::env();
        $provider();
    }

    /**
     * @expectedExceptionMessage Environment variable 'ALIBABA_CLOUD_ACCESS_KEY_SECRET' cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testEnvironmentVariableSecretEmpty()
    {
        putenv('ALIBABA_CLOUD_ACCESS_KEY_ID=id');
        putenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET=');
        $provider = CredentialsProvider::env();
        $provider();
    }

    /**
     * @throws ClientException
     */
    public function testEnvProvider()
    {
        self::assertEquals([], AlibabaCloud::all());
        $id     = \AlibabaCloud\Client\env('ACCESS_KEY_ID');
        $secret = \AlibabaCloud\Client\env('ACCESS_KEY_SECRET');
        putenv("ALIBABA_CLOUD_ACCESS_KEY_ID=$id");
        putenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET=$secret");
        $provider = CredentialsProvider::env();
        $provider();
        self::assertTrue(AlibabaCloud::has(CredentialsProvider::getDefaultName()));
    }

    public function testIniWithLoadHomeFile()
    {
        self::assertEquals([], AlibabaCloud::all());
        $provider = CredentialsProvider::ini();
        $provider();
    }

    /**
     * @depends                  testIniWithLoadHomeFile
     * @expectedExceptionMessage Environment variable 'ALIBABA_CLOUD_CREDENTIALS_FILE' cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testIniEnvironmentVariableEmpty()
    {
        putenv('ALIBABA_CLOUD_CREDENTIALS_FILE=');
        $provider = CredentialsProvider::ini();
        $provider();
    }

    /**
     * @depends testIniEnvironmentVariableEmpty
     * @throws ClientException
     */
    public function testIniWithFile()
    {
        self::assertEquals([], AlibabaCloud::all());
        $file = VirtualAccessKeyCredential::ok();
        putenv("ALIBABA_CLOUD_CREDENTIALS_FILE=$file");
        $provider = CredentialsProvider::ini();
        $provider();
        self::assertTrue(AlibabaCloud::has('ok'));
    }

    /**
     * @throws ClientException
     */
    public function testInstance()
    {
        self::assertEquals([], AlibabaCloud::all());
        putenv('ALIBABA_CLOUD_ECS_METADATA=role_name');
        $provider = CredentialsProvider::instance();
        $provider();
        self::assertTrue(AlibabaCloud::has(CredentialsProvider::getDefaultName()));
    }

    /**
     * @throws ClientException
     */
    public function testDefaultProvider()
    {
        self::assertEquals([], AlibabaCloud::all());
        $file = VirtualAccessKeyCredential::ok();
        putenv("ALIBABA_CLOUD_CREDENTIALS_FILE=$file");
        CredentialsProvider::defaultProvider('ok2');
        self::assertTrue(AlibabaCloud::has('ok'));
    }

    /**
     * @throws ClientException
     */
    public function testDefaultProviderWithEnv()
    {
        putenv('ALIBABA_CLOUD_ACCESS_KEY_ID=id');
        putenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET=secret');

        CredentialsProvider::defaultProvider(CredentialsProvider::getDefaultName());
    }

    public function testHasCustomChain()
    {
        self::assertFalse(CredentialsProvider::hasCustomChain());
    }

    /**
     * @throws ClientException
     */
    public function testFlush()
    {
        self::assertFalse(CredentialsProvider::hasCustomChain());
        CredentialsProvider::chain(
            CredentialsProvider::ini(),
            CredentialsProvider::env()
        );
        self::assertTrue(CredentialsProvider::hasCustomChain());
        CredentialsProvider::chain(
            CredentialsProvider::ini(),
            CredentialsProvider::env()
        );
        CredentialsProvider::flush();
        self::assertFalse(CredentialsProvider::hasCustomChain());
    }

    /**
     * @throws ClientException
     */
    public function testChain()
    {
        self::assertEquals([], AlibabaCloud::all());
        $file = VirtualAccessKeyCredential::ok();
        putenv("ALIBABA_CLOUD_CREDENTIALS_FILE=$file");
        CredentialsProvider::chain(
            CredentialsProvider::ini()
        );
        CredentialsProvider::customProvider(CredentialsProvider::getDefaultName());
        self::assertTrue(AlibabaCloud::has('ok'));
        self::assertTrue(CredentialsProvider::hasCustomChain());
    }

    /**
     * @expectedExceptionMessage  No providers in chain
     * @expectedException  \AlibabaCloud\Client\Exception\ClientException
     */
    public function testChainWithNoChainException()
    {
        CredentialsProvider::chain();
    }

    /**
     * @expectedExceptionMessage Providers must all be Closures
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testChaiMustBeChain()
    {
        CredentialsProvider::chain(
            CredentialsProvider::ini(),
            'exception'
        );
    }

    /**
     * @throws ClientException
     */
    public function testDefault()
    {
        self::assertEquals('default', CredentialsProvider::getDefaultName());
    }

    /**
     * @expectedExceptionMessage Environment variable 'ALIBABA_CLOUD_PROFILE' cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testEnvironmentVariableEmpty()
    {
        putenv('ALIBABA_CLOUD_PROFILE=');
        CredentialsProvider::getDefaultName();
    }

    /**
     * @throws ClientException
     */
    public function testEnvironmentVariable()
    {
        putenv('ALIBABA_CLOUD_PROFILE=test');
        self::assertEquals('test', CredentialsProvider::getDefaultName());
        putenv('ALIBABA_CLOUD_PROFILE=default');
    }

    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::flush();
    }
}
