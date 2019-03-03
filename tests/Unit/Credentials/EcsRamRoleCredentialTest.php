<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

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
     * @expectedExceptionMessage The argument $roleName cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @throws ClientException
     */
    public function testEmpty()
    {
        // Setup
        $roleName = '';

        new EcsRamRoleCredential($roleName);
    }
}
