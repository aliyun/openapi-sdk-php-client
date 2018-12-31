<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class EcsRamRoleCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\EcsRamRoleCredential
 */
class EcsRamRoleCredentialTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::getRoleName
     * @covers ::__toString
     */
    public function testConstruct()
    {
        // Setup
        $roleArn  = \getenv('ROLE_ARN');
        $expected = "roleName#$roleArn";

        // Test
        $credential = new EcsRamRoleCredential($roleArn);

        // Assert
        $this->assertEquals($roleArn, $credential->getRoleName());
        $this->assertEquals($expected, (string)$credential);
    }
}
