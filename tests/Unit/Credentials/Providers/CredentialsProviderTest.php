<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

/**
 * Class CredentialsProviderTest
 *
 * @package AlibabaCloud\Client\Tests\Feature\Credentials\Providers
 */
class CredentialsProviderTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        AlibabaCloud::flush();
    }

    /**
     * @expectedExceptionMessage Providers must all be Closures
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     */
    public function testChain()
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
}
