<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

/**
 * Use the AccessKey to complete the authentication.
 */
class AccessKeyClient extends Client
{
    /**
     * @param string $accessKeyId
     * @param string $accessKeySecret
     */
    public function __construct($accessKeyId, $accessKeySecret)
    {
        parent::__construct(
            new AccessKeyCredential($accessKeyId, $accessKeySecret),
            new ShaHmac1Signature()
        );
    }
}
