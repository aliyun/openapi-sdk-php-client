<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\ShaHmac256Signature;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;

/**
 * Use the AccessKey to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Clients
 */
class AccessKeyClient extends Client
{

    /**
     * @param string $accessKeyId
     * @param string $accessKeySecret
     *
     * @throws ClientException
     */
    public function __construct($accessKeyId, $accessKeySecret)
    {
        parent::__construct(
            new AccessKeyCredential($accessKeyId, $accessKeySecret),
            new ShaHmac256Signature()
        );
    }
}
