<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Signature\BearerTokenSignature;

/**
 * Use the Bearer Token to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Clients
 */
class BearerTokenClient extends Client
{

    /**
     * @param string $bearerToken
     */
    public function __construct($bearerToken)
    {
        parent::__construct(
            new BearerTokenCredential($bearerToken),
            new BearerTokenSignature()
        );
    }
}
