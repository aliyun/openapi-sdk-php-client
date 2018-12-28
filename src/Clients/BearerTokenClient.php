<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Signature\BearerTokenSignature;

/**
 * Use the Bearer Token to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
