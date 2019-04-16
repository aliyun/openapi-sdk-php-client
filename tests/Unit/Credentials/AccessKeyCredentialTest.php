<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;

/**
 * Class AccessKeyCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\AccessKeyCredential
 */
class AccessKeyCredentialTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = 'bar';

        // Test
        $credential = new AccessKeyCredential($accessKeyId, $accessKeySecret);

        // Assert
        $this->assertEquals($accessKeyId, $credential->getAccessKeyId());
        $this->assertEquals($accessKeySecret, $credential->getAccessKeySecret());
        $this->assertEquals("$accessKeyId#$accessKeySecret", (string)$credential);
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
        $accessKeySecret = 'bar';

        new AccessKeyCredential($accessKeyId, $accessKeySecret);
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
        $accessKeySecret = 'bar';

        new AccessKeyCredential($accessKeyId, $accessKeySecret);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret cannot be empty
     * @throws ClientException
     */
    public function testAccessKeySecretEmpty()
    {
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = '';

        // Test
        new AccessKeyCredential($accessKeyId, $accessKeySecret);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage AccessKey Secret must be a string
     * @throws ClientException
     */
    public function testAccessKeySecretFormat()
    {
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = null;

        // Test
        new AccessKeyCredential($accessKeyId, $accessKeySecret);
    }
}
