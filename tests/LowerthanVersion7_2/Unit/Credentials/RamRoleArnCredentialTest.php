<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;

/**
 * Class RamRoleArnCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials
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
        $policy          = '';

        // Test
        $credential = new RamRoleArnCredential($accessKeyId, $accessKeySecret, $arn, $sessionName);

        // Assert
        $this->assertEquals($accessKeyId, $credential->getAccessKeyId());
        $this->assertEquals($accessKeySecret, $credential->getAccessKeySecret());
        $this->assertEquals($arn, $credential->getRoleArn());
        $this->assertEquals($sessionName, $credential->getRoleSessionName());
        $this->assertEquals($policy, $credential->getPolicy());
        $this->assertEquals(
            "$accessKeyId#$accessKeySecret#$arn#$sessionName",
            (string)$credential
        );
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID cannot be empty
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID must be a string
     * @throws ClientException
     */
    public function testAccessKeyIdFormat()
    {
        // Setup
        $accessKeyId     = null;
        $accessKeySecret = 'access_key_secret';
        $arn             = 'role_arn';
        $sessionName     = 'role_session_name';

        // Test
        new RamRoleArnCredential($accessKeyId, $accessKeySecret, $arn, $sessionName);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret cannot be empty
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

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret must be a string
     * @throws ClientException
     */
    public function testAccessKeySecretFormat()
    {
        // Setup
        $accessKeyId     = 'access_key_id';
        $accessKeySecret = null;
        $arn             = 'role_arn';
        $sessionName     = 'role_session_name';

        // Test
        new RamRoleArnCredential($accessKeyId, $accessKeySecret, $arn, $sessionName);
    }
}
