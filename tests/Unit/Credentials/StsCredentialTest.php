<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\StsCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class StsCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\StsCredential
 */
class StsCredentialTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::getAccessKeyId
     * @covers ::getAccessKeySecret
     * @covers ::getSecurityToken
     * @covers ::__toString
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'accessKeyId';
        $accessKeySecret = 'accessKeySecret';
        $securityToken   = 'securityToken';

        // Test
        $credential = new StsCredential($accessKeyId, $accessKeySecret, $securityToken);

        // Assert
        $this->assertEquals($accessKeyId, $credential->getAccessKeyId());
        $this->assertEquals($accessKeySecret, $credential->getAccessKeySecret());
        $this->assertEquals($securityToken, $credential->getSecurityToken());
        $this->assertEquals(
            "$accessKeyId#$accessKeySecret#$securityToken",
            (string)$credential
        );
    }
}
