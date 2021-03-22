<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class HttpTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\ClientTrait
 */
class HttpTraitTest extends TestCase
{

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client 'default' not found
     * @throws                   ClientException
     */
    public static function testGetDefaultClient()
    {
        AlibabaCloud::flush();
        AlibabaCloud::getDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testVerify()
    {
        // Setup
        $client = AlibabaCloud::accessKeyClient('foo', 'bar')->asDefaultClient();

        // Assert
        self::assertFalse($client->options['verify']);

        // Test
        $client->verify(true);

        // Assert
        self::assertTrue($client->options['verify']);
    }

    /**
     * @throws ClientException
     */
    public static function testTimeout()
    {
        $request = AlibabaCloud::rpc()->timeout(1);
        self::assertEquals(1, $request->options['timeout']);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Timeout cannot be empty
     * @throws ClientException
     */
    public static function testTimeoutException()
    {
        AlibabaCloud::rpc()->timeout('');
    }

    /**
     * @throws ClientException
     */
    public static function testConnectTimeout()
    {
        $request = AlibabaCloud::rpc()->connectTimeout(1);
        self::assertEquals(1, $request->options['connect_timeout']);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Connect Timeout cannot be empty
     * @throws ClientException
     */
    public static function testConnectTimeoutException()
    {
        AlibabaCloud::rpc()->connectTimeout('');
    }

    /**
     * @throws ClientException
     */
    public static function testTimeoutMilliseconds()
    {
        $request = AlibabaCloud::rpc()->timeoutMilliseconds(1);
        self::assertEquals(0.001, $request->options['timeout']);
    }

    /**
     * @throws ClientException
     */
    public static function testConnectTimeoutMilliseconds()
    {
        $request = AlibabaCloud::rpc()->connectTimeoutMilliseconds(1);
        self::assertEquals(0.001, $request->options['connect_timeout']);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Milliseconds must be int
     * @throws ClientException
     */
    public static function testTimeoutMillisecondsException()
    {
        AlibabaCloud::rpc()->timeoutMilliseconds('');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Milliseconds must be int
     * @throws ClientException
     */
    public static function testConnectTimeoutMillisecondsException()
    {
        AlibabaCloud::rpc()->connectTimeoutMilliseconds('');
    }
}
