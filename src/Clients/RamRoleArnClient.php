<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

/**
 * Use the AssumeRole of the RAM account to complete  the authentication.
 *
 * @package   AlibabaCloud\Client\Clients
 */
class RamRoleArnClient extends Client
{

    /**
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $roleArn
     * @param string $roleSessionName
     */
    public function __construct($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName)
    {
        parent::__construct(
            new RamRoleArnCredential($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName),
            new ShaHmac1Signature()
        );
    }
}
