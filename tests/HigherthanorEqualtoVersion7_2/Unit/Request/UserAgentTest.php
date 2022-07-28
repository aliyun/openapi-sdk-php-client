<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\UserAgent;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class UserAgentTest
 */
class UserAgentTest extends TestCase
{
    public static function testUserAgentString()
    {
        $userAgent = UserAgent::toString();
        self::assertStringStartsWith('AlibabaCloud', $userAgent);
    }

    public static function testUserAgentStringWithAppend()
    {
        $userAgent = UserAgent::toString([
                                             'Append'  => '1.0.0',
                                             'Append2' => '2.0.0',
                                             'PHP'     => '2.0.0',
                                         ]);

        self::assertStringStartsWith('AlibabaCloud', $userAgent);
        self::assertStringEndsWith('Append/1.0.0 Append2/2.0.0', $userAgent);
    }

    public static function testUserAgentAppend()
    {
        UserAgent::append('Append', '1.0.0');
        $userAgent = UserAgent::toString();
        self::assertStringEndsWith('Append/1.0.0', $userAgent);
    }

    public static function testUserAgentWith()
    {
        UserAgent::with([
                            'Append'  => '1.0.0',
                            'Append2' => '2.0.0',
                        ]);
        $userAgent = UserAgent::toString();
        self::assertStringEndsWith('Append/1.0.0 Append2/2.0.0', $userAgent);
    }

    /**
     * @throws ClientException
     */
    public static function testGuard()
    {
        UserAgent::append('PHP', '7.3');
        self::assertStringEndsNotWith('PHP/7.3', UserAgent::toString());
        UserAgent::append('Client', '1.0.0');
        self::assertStringEndsNotWith('Client/1.0.0', UserAgent::toString());
    }

    /**
     * @throws ClientException
     */
    public function testGuardWithNameEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Name cannot be empty");
        UserAgent::append('', '7.3');
    }

    /**
     * @throws ClientException
     */
    public function testGuardWithNameFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Name must be a string");
        UserAgent::append(null, '7.3');
    }

    /**
     * @throws ClientException
     */
    public function testGuardWithValueEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Value cannot be empty");
        UserAgent::append('PHP', '');
    }

    /**
     * @throws ClientException
     */
    public function testGuardWithValueFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Value must be a string");
        UserAgent::append('PHP', null);
    }

    /**
     * @throws ClientException
     */
    public static function testAppendGlobalUserAgent()
    {
        AlibabaCloud::appendUserAgent('cli', '1.0.0');
        AlibabaCloud::appendUserAgent('cmp', 'fit2cloud');
        self::assertStringEndsWith('cli/1.0.0 cmp/fit2cloud', UserAgent::toString());
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithNameEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Name cannot be empty");
        AlibabaCloud::appendUserAgent('', '1.0.0');
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithNameFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Name must be a string");
        AlibabaCloud::appendUserAgent(null, '1.0.0');
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithValueEmpty()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Value cannot be empty");
        AlibabaCloud::appendUserAgent('cli', '');
    }

    /**
     * @throws ClientException
     */
    public function testAppendUserAgentWithValueFormat()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Value must be a string");
        AlibabaCloud::appendUserAgent('cli', null);
    }

    public static function testWithGlobalUserAgent()
    {
        AlibabaCloud::withUserAgent([
                                        'Append'  => '1.0.0',
                                        'Append2' => '2.0.0',
                                    ]);

        self::assertStringEndsWith('Append/1.0.0 Append2/2.0.0', UserAgent::toString());

        AlibabaCloud::withUserAgent([]);

        self::assertStringEndsWith('PHP/' . PHP_VERSION, UserAgent::toString());
    }

    /**
     * @throws ClientException
     */
    public static function testAppendForRequest()
    {
        AlibabaCloud::appendUserAgent('cli', '1.0.0');

        $request = new RpcRequest();
        $request->appendUserAgent('cmp', 'fit2cloud');

        // Execution request to get UA information, expected exception.
        try {
            $request->request();
        } catch (\Exception $exception) {
        }

        self::assertStringEndsWith('cli/1.0.0 cmp/fit2cloud', $request->options['headers']['User-Agent']);
        self::assertStringEndsWith('cli/1.0.0', UserAgent::toString());
    }

    /**
     * @throws ClientException
     */
    public static function testWithForRequest()
    {
        AlibabaCloud::appendUserAgent('cli', '1.0.0');
        $request = new RpcRequest();
        $request->withUserAgent([
                                    'Append'  => '1.0.0',
                                    'Append2' => '2.0.0',
                                ]);

        // Execution request to get UA information, expected exception.
        try {
            $request->request();
        } catch (\Exception $exception) {
        }

        self::assertStringEndsWith(
            'cli/1.0.0 Append/1.0.0 Append2/2.0.0',
            $request->options['headers']['User-Agent']
        );
        self::assertStringEndsWith('cli/1.0.0', UserAgent::toString());
    }

    /**
     * @throws ClientException
     */
    public static function testRequestFirst()
    {
        AlibabaCloud::appendUserAgent('cli', '1.0.0');
        $request = new RpcRequest();
        $request->withUserAgent([
                                    'Append' => '1.0.0',
                                    'cli'    => '2.0.0',
                                ]);

        // Execution request to get UA information, expected exception.
        try {
            $request->request();
        } catch (\Exception $exception) {
        }

        self::assertStringEndsWith(
            'cli/2.0.0 Append/1.0.0',
            $request->options['headers']['User-Agent']
        );
        self::assertStringEndsWith('cli/1.0.0', UserAgent::toString());
    }

    public static function testNull()
    {
        AlibabaCloud::withUserAgent([
                                        'Append' => null,
                                    ]);

        self::assertStringEndsWith('Append', UserAgent::toString());
    }

    protected function tearDown(): void
    {
        UserAgent::clear();
    }
}
