<?php

namespace AlibabaCloud\Client\Credentials\Requests;

use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Retrieving assume role credentials.
 *
 * @package   AlibabaCloud\Client\Credentials\Requests
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class AssumeRoleRequest extends RpcRequest
{

    /**
     * Class constructor.
     *
     * @param RamRoleArnCredential $arnCredential
     */
    public function __construct(RamRoleArnCredential $arnCredential)
    {
        parent::__construct();
        $this->options['query']['RoleArn']         = $arnCredential->getRoleArn();
        $this->options['query']['RoleSessionName'] = $arnCredential->getRoleSessionName();
        $this->options['query']['DurationSeconds'] = ROLE_ARN_EXPIRE_TIME;
        $this->product('Sts');
        $this->version('2015-04-01');
        $this->action('AssumeRole');
        $this->host(STS_DOMAIN);
        $this->scheme('https');
        $this->regionId('cn-hangzhou');
    }
}
