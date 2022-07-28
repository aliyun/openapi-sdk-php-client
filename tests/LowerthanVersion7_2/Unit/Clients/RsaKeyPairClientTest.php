<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Clients;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;

/**
 * Class RsaKeyPairClientTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Clients
 */
class RsaKeyPairClientTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $publicKeyId    = 'public_key_id';
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
