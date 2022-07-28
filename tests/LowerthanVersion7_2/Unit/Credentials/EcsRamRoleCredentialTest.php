<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;

/**
 * Class EcsRamRoleCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\EcsRamRoleCredential
 */
class EcsRamRoleCredentialTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $roleName = 'role_arn';
        $expected = "roleName#$roleName";

        // Test
        $credential = new EcsRamRoleCredential($roleName);

        // Assert
        $this->assertEquals($roleName, $credential->getRoleName());
        $this->assertEquals($expected, (string)$credential);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Role Name cannot be empty
     * @throws ClientException
     */
    public function testRoleNameEmpty()
    {
        // Setup
        $roleName = '';

        // Test
        new EcsRamRoleCredential($roleName);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Role Name must be a string
     * @throws ClientException
     */
    public function testRoleNameFormat()
    {
        // Setup
        $roleName = null;

        // Test
        new EcsRamRoleCredential($roleName);
    }
}
