<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;

/**
 * Class EcsRamRoleCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
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
     * @throws ClientException
     */
    public function testRoleNameEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Role Name cannot be empty');
        // Setup
        $roleName = '';

        // Test
        new EcsRamRoleCredential($roleName);
    }

    /**
     * @throws ClientException
     */
    public function testRoleNameFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Role Name must be a string');
        // Setup
        $roleName = null;

        // Test
        new EcsRamRoleCredential($roleName);
    }
}
