<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

/**
 * Use the RAM role of an ECS instance to complete the authentication.
 */
class EcsRamRoleClient extends \AlibabaCloud\Client\Clients\Client
{
    /**
     * @param string $roleName
     */
    public function __construct($roleName)
    {
        parent::__construct(
            new EcsRamRoleCredential($roleName),
            new ShaHmac1Signature()
        );
    }
}
