<?php

namespace AlibabaCloud\Client\Credentials;

use AlibabaCloud\Client\Exception\ClientException;

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
     *
     * @throws ClientException
     */
    public function __construct($roleName)
    {
        if (!$roleName) {
            throw new ClientException(
                'The argument $roleName cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

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
