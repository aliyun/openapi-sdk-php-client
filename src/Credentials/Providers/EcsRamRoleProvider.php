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
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class EcsRamRoleProvider
 *
 * @package AlibabaCloud\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */
class EcsRamRoleProvider
{
    use ProviderTrait;

    /**
     * @return StsCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function getSessionCredential()
    {
        /**
         * @var EcsRamRoleCredential $credential
         */
        $credential = $this->client->getCredential();
        $result     = $this->getCredentialsInCache($credential);
        if ($result === null) {
            $result = $this->getCredentialsFromMeta($credential);
            $this->cache($credential, $result);
        }
        return new StsCredential($result['AccessKeyId'], $result['AccessKeySecret'], $result['SecurityToken']);
    }

    /**
     * @param EcsRamRoleCredential $credential
     *
     * @return Result
     * @throws ClientException
     * @throws ServerException
     */
    private function getCredentialsFromMeta(EcsRamRoleCredential $credential)
    {
        $url = 'http://100.100.100.200/latest/meta-data/ram/security-credentials/'
               . $credential->getRoleName();

        try {
            $response = (new Client())->request(
                'GET',
                $url,
                [
                    'http_errors'     => false,
                    'timeout'         => 0.1,
                    'connect_timeout' => 0.1,
                    'debug'           => $this->client->isDebug(),
                ]
            );
            $result   = new Result($response);
        } catch (GuzzleException $e) {
            throw new ClientException($e->getMessage(), \ALI_SERVER_UNREACHABLE, $e);
        }
        if (!$result->isSuccess()) {
            throw new ServerException(
                $result,
                'Error in retrieving assume role credentials.',
                \ALI_INVALID_CREDENTIAL
            );
        }

        if (!isset($result['AccessKeyId'], $result['AccessKeySecret'], $result['SecurityToken'])) {
            throw new ServerException($result, 'Result contains no credentials', \ALI_INVALID_CREDENTIAL);
        }

        return $result;
    }

    /**
     * @param EcsRamRoleCredential $credential
     *
     * @return string
     */
    protected function key(EcsRamRoleCredential $credential)
    {
        return 'EcsRamRole#' . $credential->getRoleName();
    }
}
