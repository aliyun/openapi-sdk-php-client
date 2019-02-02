<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

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
        $userAgent = new UserAgent();
        self::assertStringStartsWith('AlibabaCloud', (string)$userAgent);
    }
}
