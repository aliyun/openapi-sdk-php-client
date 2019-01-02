<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use PHPUnit\Framework\TestCase;

/**
 * Class EcsRamRoleClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 */
class EcsRamRoleClientTest extends TestCase
{

    /**
     * @return EcsRamRoleClient
     */
    public function testConstruct()
    {
        // Setup
        $roleName = 'foo';

        // Test
        $client = new EcsRamRoleClient($roleName);

        // Assert
        self::assertEquals($roleName, $client->getCredential()->getRoleName());
        self::assertInstanceOf(EcsRamRoleCredential::class, $client->getCredential());
        self::assertInstanceOf(ShaHmac1Signature::class, $client->getSignature());

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param EcsRamRoleClient $client
     *
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(EcsRamRoleClient $client)
    {
        try {
            $client->getSessionCredential(1000);
        } catch (ClientException $exception) {
            self::assertEquals($exception->getErrorCode(), \ALIBABA_CLOUD_SERVER_UNREACHABLE);
        }
    }
}
