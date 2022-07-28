<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;

/**
 * Class BearerTokenCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Unit\Credentials
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\BearerTokenCredential
 */
class BearerTokenCredentialTest extends TestCase
{

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Bearer Token cannot be empty
     * @throws ClientException
     */
    public static function testBearerTokenEmpty()
    {
        // Setup
        $bearerToken = '';

        // Test
        new BearerTokenCredential($bearerToken);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Bearer Token must be a string
     * @throws ClientException
     */
    public static function testBearerTokenFormat()
    {
        // Setup
        $bearerToken = null;

        // Test
        new BearerTokenCredential($bearerToken);
    }

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
}
