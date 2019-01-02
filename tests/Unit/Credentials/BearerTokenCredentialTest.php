<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\BearerTokenCredential;
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
     * @covers ::__construct
     * @covers ::getBearerToken
     * @covers ::getAccessKeyId
     * @covers ::getAccessKeySecret
     * @covers ::__toString
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
