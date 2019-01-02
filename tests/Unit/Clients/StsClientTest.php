<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\Clients\StsClient;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use PHPUnit\Framework\TestCase;

/**
 * Class StsClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 */
class StsClientTest extends TestCase
{

    /**
     * @return StsClient
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = 'bar';
        $securityToken   = 'token';

        // Test
        $client = new StsClient($accessKeyId, $accessKeySecret, $securityToken);

        // Assert
        self::assertEquals($accessKeyId, $client->getCredential()->getAccessKeyId());
        self::assertEquals($accessKeySecret, $client->getCredential()->getAccessKeySecret());
        self::assertEquals($securityToken, $client->getCredential()->getSecurityToken());
        self::assertInstanceOf(ShaHmac1Signature::class, $client->getSignature());
        self::assertInstanceOf(StsCredential::class, $client->getCredential());
        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param StsClient $client
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(StsClient $client)
    {
        self::assertInstanceOf(StsCredential::class, $client->getSessionCredential());
    }
}
