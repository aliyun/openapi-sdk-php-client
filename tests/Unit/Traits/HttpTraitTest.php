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
     * @throws                   ClientException
     */
    public function testGetDefaultClient()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Client 'default' not found");
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
     * @throws ClientException
     */
    public function testTimeoutException()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Timeout cannot be empty");
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
     * @throws ClientException
     */
    public function testConnectTimeoutException()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Connect Timeout cannot be empty");
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
     * @throws ClientException
     */
    public function testTimeoutMillisecondsException()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Milliseconds must be int");
        AlibabaCloud::rpc()->timeoutMilliseconds('');
    }

    /**
     * @throws ClientException
     */
    public function testConnectTimeoutMillisecondsException()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Milliseconds must be int");
        AlibabaCloud::rpc()->connectTimeoutMilliseconds('');
    }
}
