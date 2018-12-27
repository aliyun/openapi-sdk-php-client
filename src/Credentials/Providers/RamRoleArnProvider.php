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

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\Requests\AssumeRoleRequest;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

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
     * @param int $timeout
     *
     * @return StsCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function get($timeout = \ALIBABA_CLOUD_TIMEOUT)
    {
        /**
         * @var RamRoleArnCredential $credential
         */
        $trueCredential = $this->getCredentialsInCache();

        if (null === $trueCredential) {
            $clientName = __CLASS__ . \uniqid('ak', true);
            AlibabaCloud::accessKeyClient(
                $this->client->getCredential()->getAccessKeyId(),
                $this->client->getCredential()->getAccessKeySecret()
            )->name($clientName);

            $result = (new AssumeRoleRequest($this->client->getCredential()))
                ->timeout($timeout)
                ->connectTimeout($timeout)
                ->client($clientName)
                ->debug($this->client->isDebug())
                ->request();

            if (!$result->hasKey('Credentials')) {
                throw new ClientException('Result contains no credentials', \ALI_INVALID_CREDENTIAL);
            }

            $trueCredential = $result['Credentials'];

            $this->cache($trueCredential);
        }
        return new StsCredential(
            $trueCredential['AccessKeyId'],
            $trueCredential['AccessKeySecret'],
            $trueCredential['SecurityToken']
        );
    }
}
