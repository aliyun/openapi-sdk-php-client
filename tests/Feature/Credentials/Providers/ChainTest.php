<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ChainTest
 *
 * @package AlibabaCloud\Client\Tests\Feature\Credentials\Providers
 */
class ChainTest extends TestCase
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
     * @throws ClientException
     */
    public function testIni()
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
    public function testChainException()
    {
        CredentialsProvider::chain();
    }

    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::flush();
    }
}
