<?php

namespace AlibabaCloud\Client\Support;

class SensitiveData
{
    /**
     * Redact diagnostic copies without changing the request or response.
     *
     * @param string $text
     * @param array $values
     * @return string
     */
    public static function redact($text, array $values = [])
    {
        $text = self::replaceValues($text, $values);
        $decoded = $text;
        for ($i = 0; $i < 3; $i++) {
            $masked = self::redactFields($decoded, $values);
            if ($i === 0) {
                $text = $masked;
            }
            $decoded = rawurldecode($decoded);
        }

        return self::replaceValues($text, $values);
    }

    private static function replaceValues($text, array $values)
    {
        foreach ($values as $value) {
            if (!is_string($value) || $value === '') {
                continue;
            }
            $encoded = array_unique([
                $value, rawurlencode($value), urlencode($value),
                rawurlencode(rawurlencode($value)), urlencode(urlencode($value)),
                substr(json_encode($value), 1, -1)
            ]);
            usort($encoded, static function ($left, $right) {
                return strlen($right) - strlen($left);
            });
            $text = str_ireplace($encoded, '[REDACTED]', $text);
        }

        return $text;
    }

    private static function redactFields($text, array &$values)
    {
        $names = 'AccessKeySecret|SessionAccessKeySecret|SecretAccessKey|SecurityToken|BearerToken|Signature|Authorization'
            . '|x-acs-security-token|x-acs-bearer-token';
        $text = preg_replace_callback(
            '/((?:"|\')(?:(?:' . $names . '))(?:"|\')\s*:\s*)("(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\')/i',
            static function ($match) use (&$values) {
                $values[] = $match[2][0] === '"' ? json_decode($match[2]) : substr($match[2], 1, -1);
                return $match[1] . '"[REDACTED]"';
            },
            $text
        );
        $text = preg_replace_callback('/(<(' . $names . ')>)([\s\S]*?)(<\/\2>)/i', static function ($match) use (&$values) {
            $values[] = html_entity_decode($match[3], ENT_QUOTES, 'UTF-8');
            return $match[1] . '[REDACTED]' . $match[4];
        }, $text);
        $text = preg_replace_callback('/(Authorization\s*:\s*)([^\r\n]+)/i', static function ($match) use (&$values) {
            $values[] = $match[2];
            return $match[1] . '[REDACTED]';
        }, $text);
        $text = preg_replace_callback(
            '/(?<![a-z0-9_-])(' . $names . ')(\s*[:=]\s*)([^\s&<>"\']+)/i',
            static function ($match) use (&$values) {
                $values[] = $match[3];
                return $match[1] . $match[2] . '[REDACTED]';
            },
            $text
        );

        return $text;
    }

    /**
     * @param array $data
     * @return array
     */
    public static function values(array $data)
    {
        $values = [];
        foreach ($data as $key => $value) {
            if (preg_match('/^(AccessKeySecret|SessionAccessKeySecret|SecretAccessKey|SecurityToken|BearerToken|Signature|Authorization|x-acs-security-token|x-acs-bearer-token)$/i', $key)) {
                $values = array_merge($values, (array)$value);
            } elseif (is_array($value)) {
                $values = array_merge($values, self::values($value));
            }
        }

        return $values;
    }
}
