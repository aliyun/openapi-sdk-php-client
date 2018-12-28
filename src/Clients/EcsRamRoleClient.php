<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

/**
 * Use the RAM role of an ECS instance to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
