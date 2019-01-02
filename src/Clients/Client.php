<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Http\GuzzleTrait;
use AlibabaCloud\Client\Signature\SignatureInterface;

/**
 * Custom Client.
 *
 * @package   AlibabaCloud\Client\Clients
 */
class Client
{
    use GuzzleTrait;
    use ManageTrait;

    /**
     * @var CredentialsInterface
     */
    private $credential;

    /**
     * @var SignatureInterface
     */
    private $signature;

    /**
     * Self constructor.
     *
     * @param CredentialsInterface $credential
     * @param SignatureInterface   $signature
     */
    public function __construct(CredentialsInterface $credential, SignatureInterface $signature)
    {
        $this->credential                 = $credential;
        $this->signature                  = $signature;
        $this->options['timeout']         = \ALIBABA_CLOUD_TIMEOUT;
        $this->options['connect_timeout'] = \ALIBABA_CLOUD_CONNECT_TIMEOUT;
    }

    /**
     * @return SignatureInterface
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return CredentialsInterface|AccessKeyCredential|BearerTokenCredential|StsCredential|EcsRamRoleCredential|RamRoleArnCredential|RsaKeyPairCredential
     */
    public function getCredential()
    {
        return $this->credential;
    }
}
