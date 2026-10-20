<?php

namespace AlibabaCloud\Client\Tests\Unit\Support;

use AlibabaCloud\Client\Support\SensitiveData;
use PHPUnit\Framework\TestCase;

class SensitiveDataTest extends TestCase
{
    public static function diagnostics()
    {
        $json = '{"MessageTokenDTO":{"AccessKeySecret":"secret+/=","SecurityToken":"token+/="}}';
        return [
            [$json], [rawurlencode($json)], [rawurlencode(rawurlencode($json))],
            [strtolower(rawurlencode($json))],
            ['{"SessionAccessKey":{"SessionAccessKeySecret":"secret+/="}}'],
            ['<Credentials><AccessKeySecret>secret+/=</AccessKeySecret><SecurityToken>token+/=</SecurityToken></Credentials>'],
            ['https://example.test/?Signature=signed%2B%2F%3D&SecurityToken=token%2B%2F%3D&Action=DescribeRegions'],
            ["Authorization: acs key:signed+/=\r\nx-acs-security-token: token+/=\r\nDate: today"]
        ];
    }

    /** @dataProvider diagnostics */
    public function testRedactsStructuredAndEncodedDiagnostics($text)
    {
        $output = SensitiveData::redact($text);
        foreach (['secret+/=', 'token+/=', 'signed+/='] as $value) {
            self::assertStringNotContainsString($value, $output);
            self::assertStringNotContainsString(rawurlencode($value), $output);
            self::assertStringNotContainsString(rawurlencode(rawurlencode($value)), $output);
        }
        self::assertStringContainsString('[REDACTED]', $output);
    }

    public function testKnownValuesAndSafeFields()
    {
        $text = 'request-id request-secret+/= ' . rawurlencode(rawurlencode('request-secret+/=')) . ' SignatureMethod=HMAC-SHA256';
        self::assertSame('request-id [REDACTED] [REDACTED] SignatureMethod=HMAC-SHA256', SensitiveData::redact($text, ['request-secret+/=']));
        self::assertSame(['nested-secret', 'nested-token'], SensitiveData::values([
            'MessageTokenDTO' => ['AccessKeySecret' => 'nested-secret', 'SecurityToken' => 'nested-token'],
            'SignatureMethod' => 'HMAC-SHA256'
        ]));
        self::assertSame(['header-token one & two', 'another-token'], SensitiveData::values([
            'SecurityToken' => ['header-token one & two', 'another-token']
        ]));
        self::assertSame('SecurityToken: [REDACTED]', SensitiveData::redact(
            'SecurityToken: header-token one & two', ['header-token one & two']
        ));
    }
}
