<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 */
class ClientTest extends TestCase
{

    /**
     * @return Client
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = 'bar';
        $credential      = new AccessKeyCredential($accessKeyId, $accessKeySecret);
        $signature       = new ShaHmac256WithRsaSignature();

        // Test
        $client = new Client($credential, $signature);

        // Assert
        self::assertEquals($signature, $client->getSignature());
        self::assertEquals($credential, $client->getCredential());
        self::assertEquals($accessKeyId, $client->getCredential()->getAccessKeyId());
        self::assertEquals($accessKeySecret, $client->getCredential()->getAccessKeySecret());

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testName(Client $client)
    {
        // Setup
        $name = \uniqid('', true);

        // Test
        $client->name($name);

        // Assert
        self::assertEquals($client, AlibabaCloud::get($name));
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testAsGlobalClient(Client $client)
    {
        // Setup
        $name = \ALIBABA_CLOUD_GLOBAL_CLIENT;

        // Test
        $client->asGlobalClient();

        // Assert
        self::assertEquals($client, AlibabaCloud::get($name));
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     */
    public function testIsDebug(Client $client)
    {
        // Assert
        self::assertEquals(false, $client->isDebug());

        // Test
        $client->debug(true);

        // Assert
        self::assertEquals(true, $client->isDebug());
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(Client $client)
    {
        self::assertInstanceOf(AccessKeyCredential::class, $client->getSessionCredential());
    }
}
