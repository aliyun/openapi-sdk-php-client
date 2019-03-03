<?php

namespace AlibabaCloud\Client\Credentials;

use AlibabaCloud\Client\Exception\ClientException;

/**
 * Use the AccessKey to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Credentials
 */
class AccessKeyCredential implements CredentialsInterface
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
     * AccessKeyCredential constructor.
     *
     * @param string $accessKeyId     Access key ID
     * @param string $accessKeySecret Access Key Secret
     *
     * @throws ClientException
     */
    public function __construct($accessKeyId, $accessKeySecret)
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
    public function __toString()
    {
        return "$this->accessKeyId#$this->accessKeySecret";
    }
}
