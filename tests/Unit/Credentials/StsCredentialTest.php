<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

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
     * @expectedExceptionMessage The argument $accessKeyId cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
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
     * @expectedExceptionMessage The argument $accessKeySecret cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
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
}
