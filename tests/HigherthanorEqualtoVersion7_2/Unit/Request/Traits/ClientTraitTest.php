<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\Requests\AssumeRole;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKey;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Support\Stringy;

/**
 * Class ClientTraitTest
 *
 * @package            AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Request
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
    public function testAccessKeyId()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey ID format is invalid");
        AlibabaCloud::accessKeyClient(' ', 'secret');
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeySecret()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("AccessKey Secret format is invalid");
        AlibabaCloud::accessKeyClient('key', ' ');
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
     * @throws ClientException
     */
    public function testHttpClientWithDefaultProvider()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client 'defaultprovider' not found");
        CredentialsProvider::flush();
        $request = AlibabaCloud::rpc()->client('DefaultProvider');
        $request->httpClient();
    }

    /**
     * @throws ClientException
     */
    public function testHttpClient()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client 'no' not found");
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

    /**
     * Only versions greater than 5.6 will take effect.
     *
     * @throws ClientException
     * @throws ServerException
     */
    public function testConfig()
    {
        Request::config([
                            'curl' => [CURLOPT_RESOLVE => ['cdn.aliyuncs.com:80:127.0.0.1']],
                        ]);

        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asDefaultClient()->regionId('cn-hangzhou');

        try {
            AlibabaCloud::rpc()
                        ->method('POST')
                        ->product('Cdn')
                        ->version('2014-11-11')
                        ->action('DescribeCdnService')
                        ->connectTimeout(25)
                        ->timeout(30)
                        ->request();
        } catch (ClientException $exception) {
            self::assertTrue(
                Stringy::contains($exception->getMessage(), 'Failed to connect to cdn.aliyuncs.com')
            );
        }
    }
}
