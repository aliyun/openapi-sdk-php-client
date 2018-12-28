<?php

namespace AlibabaCloud\Client\Credentials;

/**
 * Use the RAM role of an ECS instance to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class EcsRamRoleCredential implements CredentialsInterface
{

    /**
     * @var string
     */
    private $roleName;

    /**
     * Class constructor.
     *
     * @param string $roleName
     */
    public function __construct($roleName)
    {
        $this->roleName = $roleName;
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "roleName#$this->roleName";
    }
}
