<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Requests\AssumeRoleRequest;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;

/**
 * Class RamRoleArnProvider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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

            if (!$result->hasKey('Credentials')) {
                throw new ClientException(
                    'Result contains no credentials',
                    \ALI_INVALID_CREDENTIAL
                );
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

        return (new AssumeRoleRequest($this->client->getCredential()))
            ->timeout($timeout)
            ->connectTimeout($timeout)
            ->client($clientName)
            ->debug($this->client->isDebug())
            ->request();
    }
}
