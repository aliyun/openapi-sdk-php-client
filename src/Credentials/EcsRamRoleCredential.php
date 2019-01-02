<?php

namespace AlibabaCloud\Client\Credentials;

/**
 * Use the RAM role of an ECS instance to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Credentials
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
