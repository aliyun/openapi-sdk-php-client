<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

/**
 * Class BearerTokenCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\BearerTokenCredential
 */
class BearerTokenCredentialTest extends TestCase
{

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        // Setup
        $bearerToken = 'BEARER_TOKEN';
        $expected    = 'bearerToken#BEARER_TOKEN';

        // Test
        $credential = new BearerTokenCredential($bearerToken);

        // Assert
        $this->assertEquals($bearerToken, $credential->getBearerToken());
        $this->assertEquals('', $credential->getAccessKeyId());
        $this->assertEquals('', $credential->getAccessKeySecret());
        $this->assertEquals($expected, (string)$credential);
    }

    /**
     * @expectedExceptionMessage The argument $bearerToken cannot be empty
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @throws ClientException
     */
    public function testTokenEmpty()
    {
        // Setup
        $bearerToken = '';

        new BearerTokenCredential($bearerToken);
    }
}
