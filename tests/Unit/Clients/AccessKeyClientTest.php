<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\Clients\AccessKeyClient;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;
use PHPUnit\Framework\TestCase;

/**
 * Class AccessKeyClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class AccessKeyClientTest extends TestCase
{

    /**
     * @return AccessKeyClient
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
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function testGetSessionCredential(AccessKeyClient $client)
    {
        self::assertInstanceOf(AccessKeyCredential::class, $client->getSessionCredential());
    }
}
