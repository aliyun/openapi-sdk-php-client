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
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
            $result = $this->request(1);

            if (!isset($result['AccessKeyId'], $result['AccessKeySecret'], $result['SecurityToken'])) {
                throw new ServerException(
                    $result,
                    'Result contains no credentials',
                    \ALI_INVALID_CREDENTIAL
                );
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
     * @param int $timeout
     *
     * @return Result
     * @throws ClientException
     * @throws ServerException
     */
    public function request($timeout)
    {
        $result = new Result($this->getResponse($timeout));

        if (!$result->isSuccess()) {
            throw new ServerException(
                $result,
                'Error in retrieving assume role credentials.',
                \ALI_INVALID_CREDENTIAL
            );
        }

        return $result;
    }

    /**
     * Get data from meta.
     *
     * @param $timeout
     *
     * @return mixed|ResponseInterface
     * @throws ClientException
     */
    public function getResponse($timeout)
    {
        /**
         * @var EcsRamRoleCredential $credential
         */
        $credential = $this->client->getCredential();
        $url        = 'http://100.100.100.200/latest/meta-data/ram/security-credentials/'
                      . $credential->getRoleName();

        $options = [
            'http_errors'     => false,
            'timeout'         => $timeout,
            'connect_timeout' => $timeout,
            'debug'           => $this->client->isDebug(),
        ];

        try {
            return (new Client())->request('GET', $url, $options);
        } catch (GuzzleException $e) {
            throw new ClientException(
                $e->getMessage(),
                \ALI_SERVER_UNREACHABLE,
                $e
            );
        }
    }
}
