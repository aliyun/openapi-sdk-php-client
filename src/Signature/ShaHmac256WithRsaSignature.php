<?php

namespace AlibabaCloud\Client\Signature;

use AlibabaCloud\Client\Exception\ClientException;
use Exception;

/**
 * Class ShaHmac256WithRsaSignature
 *
 * @package   AlibabaCloud\Signature
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class ShaHmac256WithRsaSignature implements SignatureInterface
{

    /**
     * @param string $string
     * @param string $privateKey
     *
     * @return string
     * @throws ClientException
     */
    public function sign($string, $privateKey)
    {
        $binarySignature = '';
        try {
            openssl_sign($string, $binarySignature, $privateKey, \OPENSSL_ALGO_SHA256);
        } catch (Exception $exception) {
            throw  new ClientException($exception->getMessage(), \ALI_INVALID_CREDENTIAL);
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
