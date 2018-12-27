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

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\Requests\AssumeRoleRequest;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKeyRequest;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;

/**
 * Trait ClientTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/aliyun-openapi-php-sdk
 *
 * @mixin Request
 */
trait ClientTrait
{
    /**
     * @return Client
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function httpClient()
    {
        return AlibabaCloud::get($this->clientName);
    }

    /**
     * Return credentials directly if it is an AssumeRoleRequest or GenerateSessionAccessKeyRequest.
     *
     * @return AccessKeyCredential|BearerTokenCredential|CredentialsInterface|StsCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function credential()
    {
        if ($this instanceof AssumeRoleRequest || $this instanceof GenerateSessionAccessKeyRequest) {
            return $this->httpClient()->getCredential();
        }

        return $this->httpClient()->getSessionCredential();
    }

    /**
     * @throws ClientException
     */
    public function mergeOptionsIntoClient()
    {
        $this->options = \AlibabaCloud\Client\arrayMerge([$this->httpClient()->options, $this->options]);
    }
}
