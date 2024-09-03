<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;

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
            "$accessKeyId#$accessKeySecret##$arn#$sessionName",
            (string)$credential
        );
    }

    /**
     * @throws ClientException
     */
    public function testClient()
    {
        // Setup
        $accessKeyId     = 'access_key_id';
        $accessKeySecret = 'access_key_secret';
        $arn             = 'role_arn';
        $sessionName     = 'role_session_name';
        $policy          = '';

        AlibabaCloud::accessKeyClient(
            $accessKeyId,
            $accessKeySecret
        )->name('clientName');

        // Test
        $credential = (new RamRoleArnCredential(null, null, $arn, $sessionName))->withClient('clientName');

        // Assert
        $this->assertNull($credential->getAccessKeyId());
        $this->assertNull($credential->getAccessKeySecret());
        $this->assertEquals($arn, $credential->getRoleArn());
        $this->assertEquals($sessionName, $credential->getRoleSessionName());
        $this->assertEquals($policy, $credential->getPolicy());
        $this->assertEquals(
            "$accessKeyId#$accessKeySecret#clientName#$arn#$sessionName",
            (string)$credential
        );
    }

}
