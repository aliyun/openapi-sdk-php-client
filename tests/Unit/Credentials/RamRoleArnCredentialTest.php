<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

/**
 * Class RamRoleArnCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\RamRoleArnCredential
 */
class RamRoleArnCredentialTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'access_key_id';
        $accessKeySecret = 'access_key_secret';
        $arn             = 'role_arn';
        $sessionName     = 'role_session_name';

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

    /**
     * @expectedExceptionMessage The argument $accessKeyId cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @throws ClientException
     */
    public function testAccessKeyIdEmpty()
    {
        // Setup
        $accessKeyId     = '';
        $accessKeySecret = 'access_key_secret';
        $arn             = 'role_arn';
        $sessionName     = 'role_session_name';

        // Test
        new RamRoleArnCredential($accessKeyId, $accessKeySecret, $arn, $sessionName);
    }

    /**
     * @expectedExceptionMessage The argument $accessKeySecret cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @throws ClientException
     */
    public function testAccessKeySecretEmpty()
    {
        // Setup
        $accessKeyId     = 'access_key_id';
        $accessKeySecret = '';
        $arn             = 'role_arn';
        $sessionName     = 'role_session_name';

        // Test
        new RamRoleArnCredential($accessKeyId, $accessKeySecret, $arn, $sessionName);
    }
}
