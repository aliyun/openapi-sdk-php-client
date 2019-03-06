<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class RsaKeyPairClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 */
class RsaKeyPairClientTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $publicKeyId    = \AlibabaCloud\Client\env('PUBLIC_KEY_ID');
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();

        // Test
        $client = new RsaKeyPairClient($publicKeyId, $privateKeyFile);

        // Assert
        self::assertEquals($publicKeyId, $client->getCredential()->getPublicKeyId());
        self::assertStringEqualsFile(
            $privateKeyFile,
            $client->getCredential()->getPrivateKey()
        );
        self::assertInstanceOf(ShaHmac1Signature::class, $client->getSignature());
    }
}
