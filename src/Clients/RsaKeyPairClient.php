<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

/**
 * Use the RSA key pair to complete the authentication (supported only on Japanese site)
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RsaKeyPairClient extends Client
{

    /**
     * @param string $publicKeyId
     * @param string $privateKeyFile
     *
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function __construct($publicKeyId, $privateKeyFile)
    {
        parent::__construct(
            new RsaKeyPairCredential($publicKeyId, $privateKeyFile),
            new ShaHmac1Signature()
        );
    }
}
