<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;
use AlibabaCloud\Client\Credentials\Providers\CredentialsProvider;

/**
 * Class ClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 */
class ClientTest extends TestCase
{

    /**
     * @return Client
     * @throws ClientException
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
     * @throws ClientException
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
     * @depends                  testConstruct
     *
     * @param Client $client
     *
     * @throws ClientException
     */
    public function testNameEmpty(Client $client)
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Name cannot be empty');
        $client->name('');
    }

    /**
     * @depends                  testConstruct
     *
     * @param Client $client
     *
     * @throws ClientException
     */
    public function testNameFormat(Client $client)
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Name must be a string');
        $client->name(null);
    }

    /**
     * @depends testConstruct
     *
     * @param Client $client
     *
     * @throws ClientException
     */
    public function testAsDefaultClient(Client $client)
    {
        // Setup
        $name = CredentialsProvider::getDefaultName();

        // Test
        $client->asDefaultClient();

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
     * @throws ClientException
     * @throws ServerException
     */
    public function testGetSessionCredential(Client $client)
    {
        self::assertInstanceOf(AccessKeyCredential::class, $client->getSessionCredential());
    }
}
