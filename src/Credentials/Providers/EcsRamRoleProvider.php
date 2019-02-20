<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class EcsRamRoleProvider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
 */
class EcsRamRoleProvider extends Provider
{

    /**
     * Get credential.
     *
     * @return StsCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function get()
    {
        $result = $this->getCredentialsInCache();

        if ($result === null) {
            $result = $this->request();

            if (!isset($result['AccessKeyId'], $result['AccessKeySecret'], $result['SecurityToken'])) {
                throw new ServerException($result, 'Result contains no credentials', \ALIBABA_CLOUD_INVALID_CREDENTIAL);
            }

            $this->cache($result->toArray());
        }

        return new StsCredential(
            $result['AccessKeyId'],
            $result['AccessKeySecret'],
            $result['SecurityToken']
        );
    }

    /**
     * Get credentials by request.
     *
     * @return Result
     * @throws ClientException
     * @throws ServerException
     */
    public function request()
    {
        $result = new Result($this->getResponse());

        if (!$result->isSuccess()) {
            throw new ServerException(
                $result,
                'Error in retrieving assume role credentials.',
                \ALIBABA_CLOUD_INVALID_CREDENTIAL
            );
        }

        return $result;
    }

    /**
     * Get data from meta.
     *
     * @return mixed|ResponseInterface
     * @throws ClientException
     */
    public function getResponse()
    {
        /**
         * @var EcsRamRoleCredential $credential
         */
        $credential = $this->client->getCredential();
        $url        = 'http://100.100.100.200/latest/meta-data/ram/security-credentials/'
                      . $credential->getRoleName();

        $options = [
            'http_errors'     => false,
            'timeout'         => 1,
            'connect_timeout' => 1,
            'debug'           => $this->client->isDebug(),
        ];

        try {
            return (new Client())->request('GET', $url, $options);
        } catch (GuzzleException $e) {
            throw new ClientException(
                $e->getMessage(),
                \ALIBABA_CLOUD_SERVER_UNREACHABLE,
                $e
            );
        }
    }
}
