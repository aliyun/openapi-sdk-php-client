<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;

/**
 * Class RamRoleArnClientTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Clients
 */
class RamRoleArnClientTest extends TestCase
{

    /**
     * @return RamRoleArnClient
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = '$accessKeyId';
        $accessKeySecret = '$accessKeyId';
        $roleArn         = '';
        $roleSessionName = '';

        // Test
        $client = new RamRoleArnClient($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName);

        // Assert
        self::assertInstanceOf(ShaHmac1Signature::class, $client->getSignature());
        self::assertInstanceOf(RamRoleArnCredential::class, $client->getCredential());
        self::assertEquals($accessKeyId, $client->getCredential()->getAccessKeyId());
        self::assertEquals($accessKeySecret, $client->getCredential()->getAccessKeySecret());
        self::assertEquals($roleArn, $client->getCredential()->getRoleArn());
        self::assertEquals($roleSessionName, $client->getCredential()->getRoleSessionName());

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param RamRoleArnClient $client
     */
    public function testGetSessionCredential(RamRoleArnClient $client)
    {
        try {
            $client->getSessionCredential();
        } catch (ServerException $exception) {
            self::assertEquals('Specified access key is not found or invalid.', $exception->getErrorMessage());
        } catch (ClientException $exception) {
            self::assertStringStartsWith('cURL error', $exception->getErrorMessage());
        }
    }
}
