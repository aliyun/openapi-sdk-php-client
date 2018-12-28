<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class RamRoleArnCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\RamRoleArnCredential
 */
class RamRoleArnCredentialTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::getAccessKeyId
     * @covers ::getAccessKeySecret
     * @covers ::getRoleArn
     * @covers ::getRoleSessionName
     * @covers ::__toString
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        $arn             = \getenv('ROLE_ARN');
        $sessionName     = \getenv('ROLE_SESSION_NAME');

        // Test
        $credential = new RamRoleArnCredential($accessKeyId, $accessKeySecret, $arn, $sessionName);

        // Assert
        $this->assertEquals($accessKeyId, $credential->getAccessKeyId());
        $this->assertEquals($accessKeySecret, $credential->getAccessKeySecret());
        $this->assertEquals($arn, $credential->getRoleArn());
        $this->assertEquals($sessionName, $credential->getRoleSessionName());
        $this->assertEquals(
            "$accessKeyId#$accessKeySecret#$arn#$sessionName",
            (string)$credential
        );
    }
}
