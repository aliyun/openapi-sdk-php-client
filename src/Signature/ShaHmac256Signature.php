<?php

namespace AlibabaCloud\Client\Signature;

/**
 * Class ShaHmac256Signature
 *
 * @package   AlibabaCloud\Signature
 */
class ShaHmac256Signature implements SignatureInterface
{

    /**
     * @param string $string
     * @param string $accessKeySecret
     *
     * @return string
     */
    public function sign($string, $accessKeySecret)
    {
        return base64_encode(hash_hmac('sha256', $string, $accessKeySecret, true));
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'HMAC-SHA256';
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
        return '';
    }
}
