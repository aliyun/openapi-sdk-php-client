<?php

namespace AlibabaCloud\Client\Tests\Unit\Request\Traits;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Credentials\Requests\AssumeRole;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKey;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

/**
 * Class ClientTraitTest
 *
 * @package            AlibabaCloud\Client\Tests\Unit\Request
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\Request
 */
class ClientTraitTest extends TestCase
{
    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testCredential()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asDefaultClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new DescribeCdnServiceRequest())->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }

    /**
     * @throws ClientException
     */
    public function testHttpClientWithCustomChain()
    {
        $name = 'testHttpClientWithCustomChain';
        AlibabaCloud::flush();
        CredentialsProvider::chain(
            static function () use ($name) {
                AlibabaCloud::ecsRamRoleClient('role')->name($name);
            }
        );
        $request = AlibabaCloud::rpc()->client($name);
        self::assertInstanceOf(EcsRamRoleClient::class, $request->httpClient());
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client 'DefaultProvider' not found
     * @throws ClientException
     */
    public function testHttpClientWithDefaultProvider()
    {
        CredentialsProvider::flush();
        $request = AlibabaCloud::rpc()->client('DefaultProvider');
        $request->httpClient();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client 'no' not found
     * @throws ClientException
     */
    public function testHttpClient()
    {
        $request = AlibabaCloud::rpc()->client('no');
        $request->httpClient();
    }

    /**
     * @throws ClientException
     */
    public function testMergeOptionsIntoClient()
    {
        // Setup
        $clientName = __METHOD__;
        $expected   = 'i \'m request';

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asDefaultClient()
                    ->regionId('cn-hangzhou')
                    ->options(
                        [
                            'headers' => [
                                'client' => 'client',
                            ],
                        ]
                    )
                    ->name($clientName);

        $request = (new DescribeCdnServiceRequest())->client($clientName)
                                                    ->options(['request1' => 'request'])
                                                    ->options(['request2' => 'request2'])
                                                    ->options(
                                                        [
                                                            'headers' => [
                                                                'client' => $expected,
                                                            ],
                                                        ]
                                                    );
        $request->mergeOptionsIntoClient();

        // Assert
        $this->assertEquals($expected, $request->options['headers']['client']);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testCredentialOnAssumeRole()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asDefaultClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new AssumeRole(
            new RamRoleArnCredential(
                'key',
                'secret',
                'arn',
                'name'
            )
        ))->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testCredentialOnGenerateSessionAccessKey()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asDefaultClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new GenerateSessionAccessKey(
            new RsaKeyPairCredential(
                'key',
                VirtualRsaKeyPairCredential::ok()
            )
        ))->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }
}
