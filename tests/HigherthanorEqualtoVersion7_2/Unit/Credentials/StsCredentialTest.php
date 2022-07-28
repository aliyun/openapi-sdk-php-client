<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\StsCredential;

/**
 * Class StsCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials
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
     * @throws ClientException
     */
    public function testAccessKeyIdEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('AccessKey ID cannot be empty');
        // Setup
        $accessKeyId     = '';
        $accessKeySecret = 'accessKeySecret';
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeyIdFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('AccessKey ID must be a string');
        // Setup
        $accessKeyId     = null;
        $accessKeySecret = 'accessKeySecret';
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeySecretEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('AccessKey Secret cannot be empty');
        // Setup
        $accessKeyId     = 'accessKeyId';
        $accessKeySecret = '';
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeySecretFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('AccessKey Secret must be a string');
        // Setup
        $accessKeyId     = 'accessKeyId';
        $accessKeySecret = null;
        $securityToken   = 'securityToken';

        new StsCredential($accessKeyId, $accessKeySecret, $securityToken);
    }
}
