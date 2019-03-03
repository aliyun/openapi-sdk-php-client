<?php

namespace AlibabaCloud\Client\Credentials;

use AlibabaCloud\Client\Exception\ClientException;

/**
 * Use the STS Token to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Credentials
 */
class StsCredential implements CredentialsInterface
{

    /**
     * @var string
     */
    private $accessKeyId;

    /**
     * @var string
     */
    private $accessKeySecret;

    /**
     * @var string
     */
    private $securityToken;

    /**
     * StsCredential constructor.
     *
     * @param string $accessKeyId     Access key ID
     * @param string $accessKeySecret Access Key Secret
     * @param string $securityToken   Security Token
     *
     * @throws ClientException
     */
    public function __construct($accessKeyId, $accessKeySecret, $securityToken = '')
    {
        if (!$accessKeyId) {
            throw new ClientException(
                'The argument $accessKeyId cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if (!$accessKeySecret) {
            throw new ClientException(
                'The argument $accessKeySecret cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        $this->accessKeyId     = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->securityToken   = $securityToken;
    }

    /**
     * @return string
     */
    public function getAccessKeyId()
    {
        return $this->accessKeyId;
    }

    /**
     * @return string
     */
    public function getAccessKeySecret()
    {
        return $this->accessKeySecret;
    }

    /**
     * @return string
     */
    public function getSecurityToken()
    {
        return $this->securityToken;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->accessKeyId#$this->accessKeySecret#$this->securityToken";
    }
}
