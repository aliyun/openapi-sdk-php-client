<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKeyRequest;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;

/**
 * Class RsaKeyPairProvider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RsaKeyPairProvider extends Provider
{

    /**
     * Get credential.
     *
     * @param int $timeout
     *
     * @return AccessKeyCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function get($timeout = \ALIBABA_CLOUD_TIMEOUT)
    {
        $credential = $this->getCredentialsInCache();

        if ($credential === null) {
            $result = $this->request($timeout);

            if (!$result->hasKey('SessionAccessKey')) {
                throw new ClientException(
                    'Result contains no SessionAccessKey',
                    \ALI_INVALID_CREDENTIAL
                );
            }

            $credential = $result['SessionAccessKey'];
            $this->cache($credential);
        }

        return new AccessKeyCredential(
            $credential['SessionAccessKeyId'],
            $credential['SessionAccessKeySecret']
        );
    }

    /**
     * Get credentials by request.
     *
     * @param int $timeout
     *
     * @return Result
     * @throws ClientException
     * @throws ServerException
     */
    private function request($timeout)
    {
        $clientName = __CLASS__ . \uniqid('rsa', true);

        AlibabaCloud::client(
            new AccessKeyCredential(
                $this->client->getCredential()->getPublicKeyId(),
                $this->client->getCredential()->getPrivateKey()
            ),
            new ShaHmac256WithRsaSignature()
        )->name($clientName);

        return (new GenerateSessionAccessKeyRequest($this->client->getCredential()))
            ->client($clientName)
            ->timeout($timeout)
            ->connectTimeout($timeout)
            ->debug($this->client->isDebug())
            ->request();
    }
}
