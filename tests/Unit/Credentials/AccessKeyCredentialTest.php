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
     * @throws ClientException
     */
    public function testAccessKeyIdEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('AccessKey ID cannot be empty');
        // Setup
        $accessKeyId     = '';
        $accessKeySecret = 'bar';

        new AccessKeyCredential($accessKeyId, $accessKeySecret);
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
        $accessKeySecret = 'bar';

        new AccessKeyCredential($accessKeyId, $accessKeySecret);
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeySecretEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('AccessKey Secret cannot be empty');
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = '';

        // Test
        new AccessKeyCredential($accessKeyId, $accessKeySecret);
    }

    /**
     * @throws ClientException
     */
    public function testAccessKeySecretFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('AccessKey Secret must be a string');
        // Setup
        $accessKeyId     = 'foo';
        $accessKeySecret = null;

        // Test
        new AccessKeyCredential($accessKeyId, $accessKeySecret);
    }
}
