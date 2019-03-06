<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKey;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Client\SDK;
use AlibabaCloud\Client\Signature\ShaHmac256WithRsaSignature;

/**
 * Class RsaKeyPairProvider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
 */
class RsaKeyPairProvider extends Provider
{

    /**
     * Get credential.
     *
     * @param int $timeout
     *
     * @return StsCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function get($timeout = Request::TIMEOUT)
    {
        $credential = $this->getCredentialsInCache();

        if ($credential === null) {
            $result = $this->request($timeout);

            if (!isset($result['SessionAccessKey']['SessionAccessKeyId'],
                $result['SessionAccessKey']['SessionAccessKeySecret'])) {
                throw new ServerException($result, $this->error, SDK::INVALID_CREDENTIAL);
            }

            $credential = $result['SessionAccessKey'];
            $this->cache($credential);
        }

        return new StsCredential(
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

        return (new GenerateSessionAccessKey($this->client->getCredential()))
            ->client($clientName)
            ->timeout($timeout)
            ->connectTimeout($timeout)
            ->debug($this->client->isDebug())
            ->request();
    }
}
