<?php

namespace AlibabaCloud\Client\Credentials;

use AlibabaCloud\Client\Exception\ClientException;
use Exception;

/**
 * Use the RSA key pair to complete the authentication (supported only on Japanese site)
 *
 * @package   AlibabaCloud\Client\Credentials
 */
class RsaKeyPairCredential implements CredentialsInterface
{

    /**
     * @var string
     */
    private $publicKeyId;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * RsaKeyPairCredential constructor.
     *
     * @param string $publicKeyId
     * @param string $privateKeyFile
     *
     * @throws ClientException
     */
    public function __construct($publicKeyId, $privateKeyFile)
    {
        $this->publicKeyId = $publicKeyId;
        try {
            $this->privateKey = file_get_contents($privateKeyFile);
        } catch (Exception $exception) {
            throw new ClientException(
                $exception->getMessage(),
                \ALIBABA_CLOUD_INVALID_CREDENTIAL
            );
        }
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getPublicKeyId()
    {
        return $this->publicKeyId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "publicKeyId#$this->publicKeyId";
    }
}
