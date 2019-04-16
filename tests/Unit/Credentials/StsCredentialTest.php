<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\StsCredential;

/**
 * Class StsCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\StsCredential
 */
class StsCredentialTest extends TestCase
{

    /**
     * @throws ClientException
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

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey ID cannot be empty
     * @throws ClientException
     */
    public function testAccessKeyIdEmpty()
    {
        // Setup
        $accessKeyId     = '';
        $accessKeySecret = 'accessKeySecret';
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
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
        $accessKeySecret = 'accessKeySecret';
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret cannot be empty
     * @throws ClientException
     */
    public function testAccessKeySecretEmpty()
    {
        // Setup
        $accessKeyId     = 'accessKeyId';
        $accessKeySecret = '';
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret must be a string
     * @throws ClientException
     */
    public function testAccessKeySecretFormat()
    {
        // Setup
        $accessKeyId     = 'accessKeyId';
        $accessKeySecret = null;
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
    }
}
