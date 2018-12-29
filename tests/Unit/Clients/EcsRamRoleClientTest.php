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
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
            self::assertEquals($exception->getErrorCode(), \ALI_SERVER_UNREACHABLE);
        }
    }
}
