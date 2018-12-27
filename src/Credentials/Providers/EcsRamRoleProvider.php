<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Credentials\Providers;

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
            $this->cache($result);
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
        $url = 'http://100.100.100.200/latest/meta-data/ram/security-credentials/'
               . $this->client->getCredential()->getRoleName();

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
