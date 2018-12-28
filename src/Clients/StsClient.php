<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

/**
 * Use the STS Token to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class StsClient extends Client
{

    /**
     * @param string $accessKeyId     Access key ID
     * @param string $accessKeySecret Access Key Secret
     * @param string $securityToken   Security Token
     */
    public function __construct($accessKeyId, $accessKeySecret, $securityToken)
    {
        parent::__construct(
            new StsCredential($accessKeyId, $accessKeySecret, $securityToken),
            new ShaHmac1Signature()
        );
    }
}
