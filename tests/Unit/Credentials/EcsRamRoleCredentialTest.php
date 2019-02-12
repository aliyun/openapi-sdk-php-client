<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class EcsRamRoleCredentialTest.
 *
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
        $this->assertEquals($expected, (string) $credential);
    }
}
