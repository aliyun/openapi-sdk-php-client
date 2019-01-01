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
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RsaKeyPairClientTest extends TestCase
{

    /**
     * @return RsaKeyPairClient
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $publicKeyId    = \time();
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

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param RsaKeyPairClient $client
     *
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(RsaKeyPairClient $client)
    {
        try {
            $client->getSessionCredential();
        } catch (ClientException $exception) {
            self::assertEquals(
                $exception->getErrorCode(),
                \ALIBABA_CLOUD_INVALID_CREDENTIAL
            );
        }
    }
}
