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
 * @category   AlibabaCloud
 *
 * @author     Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright  Alibaba Group
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link       https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Http\GuzzleTrait;
use AlibabaCloud\Client\Signature\SignatureInterface;

/**
 * Custom Client.
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class Client
{
    use GuzzleTrait;
    use ManageTrait;

    /**
     * @var CredentialsInterface
     */
    private $credential;

    /**
     * @var SignatureInterface
     */
    private $signature;

    /**
     * Self constructor.
     *
     * @param CredentialsInterface $credential
     * @param SignatureInterface   $signature
     */
    public function __construct(CredentialsInterface $credential, SignatureInterface $signature)
    {
        $this->credential                 = $credential;
        $this->signature                  = $signature;
        $this->options['timeout']         = \ALIBABA_CLOUD_TIMEOUT;
        $this->options['connect_timeout'] = \ALIBABA_CLOUD_CONNECT_TIMEOUT;
    }

    /**
     * @return SignatureInterface
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return CredentialsInterface|AccessKeyCredential|BearerTokenCredential|StsCredential|EcsRamRoleCredential|RamRoleArnCredential|RsaKeyPairCredential
     */
    public function getCredential()
    {
        return $this->credential;
    }
}
