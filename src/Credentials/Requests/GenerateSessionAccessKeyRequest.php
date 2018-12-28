<?php

namespace AlibabaCloud\Client\Credentials\Requests;

use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Use the RSA key pair to complete the authentication (supported only on Japanese site)
 *
 * @package   AlibabaCloud\Client\Credentials\Requests
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class GenerateSessionAccessKeyRequest extends RpcRequest
{

    /**
     * Class constructor.
     *
     * @param RsaKeyPairCredential $credential
     */
    public function __construct(RsaKeyPairCredential $credential)
    {
        parent::__construct();
        $this->product('Sts');
        $this->version('2015-04-01');
        $this->action('GenerateSessionAccessKey');
        $this->host('sts.ap-northeast-1.aliyuncs.com');
        $this->options['query']['PublicKeyId']     = $credential->getPublicKeyId();
        $this->options['query']['DurationSeconds'] = ROLE_ARN_EXPIRE_TIME;
        $this->scheme('https');
        $this->regionId('cn-hangzhou');
    }
}
