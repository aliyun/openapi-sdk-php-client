<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

/**
 * Class VirtualEcsRamRoleCredential
 *
 * @codeCoverageIgnore
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 */
class VirtualEcsRamRoleCredential extends VirtualAccessKeyCredential
{

    /**
     * @return string
     */
    public static function noRoleName()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ecs_ram_role
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
type = ecs_ram_role
role_name = role_name
EOT;
        return (new static($content))->url();
    }
}
