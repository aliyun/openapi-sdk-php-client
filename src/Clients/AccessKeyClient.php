<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

/**
 * Use the AccessKey to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
