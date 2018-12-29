<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

/**
 * Class VirtualEcsRamRoleCredential
 *
 * @codeCoverageIgnore
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
