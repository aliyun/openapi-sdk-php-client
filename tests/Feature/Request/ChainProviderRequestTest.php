<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\SDK;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualAccessKeyCredential;

/**
 * Class ChainRequestTest
 *
 * @package AlibabaCloud\Client\Tests\Feature\Request
 */
class ChainProviderRequestTest extends TestCase
{

    /**
     * @before
     */
    protected function initialize()
    {
        parent::setUp();
        AlibabaCloud::flush();
        CredentialsProvider::flush();
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testDefaultProviderOnInstance()
    {

        // Setup
        CredentialsProvider::chain(
            CredentialsProvider::ini(),
            CredentialsProvider::instance(),
            CredentialsProvider::env()
        );

        $role = 'EcsRamRoleTest';
        putenv("ALIBABA_CLOUD_ECS_METADATA=$role");

        // Void ini
        $content = <<<EOT
[void_client]
enable = true
type = access_key
access_key_id = foo
access_key_secret = var
region_id = cn-hangzhou
EOT;
        $file = (new VirtualAccessKeyCredential($content, 'testDefaultProviderOnInstance'))->url();
        putenv("ALIBABA_CLOUD_CREDENTIALS_FILE=$file");
        AlibabaCloud::flush();

        // Test
        AlibabaCloud::setDefaultRegionId('cn-hangzhou');
        try {
            AlibabaCloud::rpc()
                ->method('POST')
                ->product('Cdn')
                ->version('2014-11-11')
                ->action('DescribeCdnService')
                ->connectTimeout(25)
                ->timeout(30)
                ->debug(true)
                ->request();
        } catch (ClientException $e) {
            self::assertEquals(SDK::SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     * @depends testDefaultProviderOnInstance
     * @throws ServerException
     * @throws ClientException
     */
    public function testDefaultProviderOnEnv()
    {

        // Setup
        $id = \AlibabaCloud\Client\env('ACCESS_KEY_ID');
        $secret = \AlibabaCloud\Client\env('ACCESS_KEY_SECRET');
        putenv("ALIBABA_CLOUD_ACCESS_KEY_ID=$id");
        putenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET=$secret");

        // Test
        AlibabaCloud::setDefaultRegionId('cn-hangzhou');
        $result = AlibabaCloud::rpc()
            ->method('POST')
            ->product('Cdn')
            ->version('2014-11-11')
            ->action('DescribeCdnService')
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        self::assertNotEmpty('PayByTraffic', $result['ChangingChargeType']);
    }

    /**
     * @depends testDefaultProviderOnEnv
     * @throws ServerException
     * @throws ClientException
     */
    public function testDefaultProviderOnIni()
    {

        // Setup
        $id = \AlibabaCloud\Client\env('ACCESS_KEY_ID');
        $secret = \AlibabaCloud\Client\env('ACCESS_KEY_SECRET');
        $content = <<<EOT
[testDefaultProviderOnIni]
enable = true
type = access_key
access_key_id = $id
access_key_secret = $secret
region_id = cn-hangzhou
EOT;

        $file = (new VirtualAccessKeyCredential($content, 'testDefaultProviderOnIni'))->url();
        putenv("ALIBABA_CLOUD_CREDENTIALS_FILE=$file");

        // Test
        AlibabaCloud::setDefaultRegionId('cn-hangzhou');
        $result = AlibabaCloud::rpc()
            ->client('testDefaultProviderOnIni')
            ->method('POST')
            ->product('Cdn')
            ->version('2014-11-11')
            ->action('DescribeCdnService')
            ->connectTimeout(25)
            ->timeout(30)
            ->request();

        self::assertNotEmpty('PayByTraffic', $result['ChangingChargeType']);
    }

}
