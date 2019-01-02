<?php

namespace AlibabaCloud\Client\Credentials\Requests;

use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Use the RSA key pair to complete the authentication (supported only on Japanese site)
 *
 * @package   AlibabaCloud\Client\Credentials\Requests
 */
class GenerateSessionAccessKey extends RpcRequest
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
        $this->options['query']['DurationSeconds'] = ALIBABA_CLOUD_STS_EXPIRE;
        $this->scheme('https');
        $this->regionId('cn-hangzhou');
    }
}
