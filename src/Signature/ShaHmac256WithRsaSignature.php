<?php

namespace AlibabaCloud\Client\Signature;

use AlibabaCloud\Client\Exception\ClientException;
use Exception;

/**
 * Class ShaHmac256WithRsaSignature.
 */
class ShaHmac256WithRsaSignature implements SignatureInterface
{
    /**
     * @param string $string
     * @param string $privateKey
     *
     * @return string
     *
     * @throws ClientException
     */
    public function sign($string, $privateKey)
    {
        $binarySignature = '';
        try {
            openssl_sign(
                $string,
                $binarySignature,
                $privateKey,
                \OPENSSL_ALGO_SHA256
            );
        } catch (Exception $exception) {
            throw  new ClientException(
                $exception->getMessage(),
                \ALIBABA_CLOUD_INVALID_CREDENTIAL
            );
        }

        return base64_encode($binarySignature);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'SHA256withRSA';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'PRIVATEKEY';
    }
}
