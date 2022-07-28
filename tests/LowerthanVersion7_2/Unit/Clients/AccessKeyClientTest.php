<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Clients;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Clients\AccessKeyClient;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;

/**
 * Class AccessKeyClientTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Clients
 */
class AccessKeyClientTest extends TestCase
{

    /**
     * @return AccessKeyClient
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = 'bar';

        // Test
        $client = new AccessKeyClient($accessKeyId, $accessKeySecret);

        // Assert
        self::assertEquals($accessKeyId, $client->getCredential()->getAccessKeyId());
        self::assertEquals($accessKeySecret, $client->getCredential()->getAccessKeySecret());
        self::assertInstanceOf(ShaHmac1Signature::class, $client->getSignature());

        return $client;
    }

    /**
     * @depends testConstruct
     *
     * @param AccessKeyClient $client
     *
     * @throws ClientException
     * @throws ServerException
     */
    public function testGetSessionCredential(AccessKeyClient $client)
    {
        self::assertInstanceOf(AccessKeyCredential::class, $client->getSessionCredential());
    }
}
