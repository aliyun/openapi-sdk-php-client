<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Requests\AssumeRole;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;

/**
 * Class RamRoleArnProvider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
 */
class RamRoleArnProvider extends Provider
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
    public function get($timeout = \ALIBABA_CLOUD_TIMEOUT)
    {
        $credential = $this->getCredentialsInCache();

        if (null === $credential) {
            $result = $this->request($timeout);

            if (!isset($result['Credentials']['AccessKeyId'],
                $result['Credentials']['AccessKeySecret'],
                $result['Credentials']['SecurityToken'])) {
                throw new ServerException($result, 'Result contains no credentials', \ALIBABA_CLOUD_INVALID_CREDENTIAL);
            }

            $credential = $result['Credentials'];
            $this->cache($credential);
        }

        return new StsCredential(
            $credential['AccessKeyId'],
            $credential['AccessKeySecret'],
            $credential['SecurityToken']
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
        $clientName = __CLASS__ . \uniqid('ak', true);

        AlibabaCloud::accessKeyClient(
            $this->client->getCredential()->getAccessKeyId(),
            $this->client->getCredential()->getAccessKeySecret()
        )->name($clientName);

        return (new AssumeRole($this->client->getCredential()))
            ->timeout($timeout)
            ->connectTimeout($timeout)
            ->client($clientName)
            ->debug($this->client->isDebug())
            ->request();
    }
}
