<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\UserAgent;
use PHPUnit\Framework\TestCase;

/**
 * Class UserAgentTest
 *
 * @package            AlibabaCloud\Client\Tests\Unit\Request
 */
class UserAgentTest extends TestCase
{
    public function testUserAgentString()
    {
        $userAgent = UserAgent::toString();
        self::assertStringStartsWith('AlibabaCloud', $userAgent);
    }

    public function testGuard()
    {
        UserAgent::append('PHP', '7.3');
        self::assertStringEndsNotWith('PHP/7.3', UserAgent::toString());
        UserAgent::append('Client', '1.0.0');
        self::assertStringEndsNotWith('Client/1.0.0', UserAgent::toString());
    }

    public function testGlobalUserAgent()
    {
        AlibabaCloud::userAgentAppend('Test', 'Test');
        $userAgent = UserAgent::toString();
        self::assertStringEndsWith('Test/Test', $userAgent);
    }
}
