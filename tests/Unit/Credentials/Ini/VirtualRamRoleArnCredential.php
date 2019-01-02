<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

/**
 * Class VirtualRamRoleArnCredential
 *
 * @codeCoverageIgnore
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 */
class VirtualRamRoleArnCredential extends VirtualAccessKeyCredential
{

    /**
     * @return string
     */
    public static function noKey()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
role_arn = role_arn
role_session_name = role_session_name
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noSecret()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
access_key_id = access_key_id
role_arn = role_arn
role_session_name = role_session_name
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noRoleArn()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
access_key_id = access_key_id
access_key_secret = access_key_secret
role_session_name = role_session_name
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noRoleSessionName()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
access_key_id = access_key_id
access_key_secret = access_key_secret
role_arn = role_arn
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function client()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
access_key_id = access_key_id
access_key_secret = access_key_secret
role_arn = role_arn
role_session_name = role_session_name
EOT;
        return (new static($content))->url();
    }
}
