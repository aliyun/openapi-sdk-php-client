<?php

namespace AlibabaCloud\Client\Tests\Unit\Signature;

use AlibabaCloud\Client\Signature\ShaHmac256Signature;
use PHPUnit\Framework\TestCase;

/**
 * Class ShaHmac256SignatureTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Signature
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Signature\ShaHmac256Signature
 */
class ShaHmac256SignatureTest extends TestCase
{

    /**
     * @covers ::sign
     * @covers ::getMethod
     * @covers ::getVersion
     * @covers ::getType
     */
    public function testShaHmac256Signature()
    {
        // Setup
        $string          = 'this is a ShaHmac256 test.';
        $accessKeySecret = 'accessKeySecret';
        $expected        = 'v1Kg2HYGWRaLsRu2iXkAZu3R7vDh0txyYHs48HVxkeA=';

        // Test
        $signature = new ShaHmac256Signature();

        // Assert
        $this->assertInstanceOf(ShaHmac256Signature::class, $signature);
        $this->assertEquals('HMAC-SHA256', $signature->getMethod());
        $this->assertEquals('1.0', $signature->getVersion());
        $this->assertEquals('', $signature->getType());
        $this->assertEquals(
            $expected,
            $signature->sign($string, $accessKeySecret)
        );
    }
}
