<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Signature\BearerTokenSignature;
use PHPUnit\Framework\TestCase;

/**
 * Class BearerTokenClientTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Clients
 */
class BearerTokenClientTest extends TestCase
{

    /**
     * @return BearerTokenClient
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
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(BearerTokenClient $client)
    {
        self::assertInstanceOf(BearerTokenCredential::class, $client->getSessionCredential());
    }
}
