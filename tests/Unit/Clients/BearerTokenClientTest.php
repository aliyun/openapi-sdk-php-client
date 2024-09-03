<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Signature\BearerTokenSignature;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;

/**
 * Class BearerTokenClientTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Clients
 */
class BearerTokenClientTest extends TestCase
{

    /**
     * @return BearerTokenClient
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $bearerToken = 'bearerToken';

        // Test
        $client = new BearerTokenClient($bearerToken);

        // Assert
        self::assertEquals($bearerToken, $client->getCredential()->getBearerToken());
        self::assertInstanceOf(BearerTokenSignature::class, $client->getSignature());

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param BearerTokenClient $client
     *
     * @throws ClientException
     * @throws ServerException
     */
    public function testGetSessionCredential(BearerTokenClient $client)
    {
        self::assertInstanceOf(BearerTokenCredential::class, $client->getSessionCredential());
    }
}
