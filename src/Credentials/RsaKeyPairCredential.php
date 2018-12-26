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

namespace AlibabaCloud\Client\Credentials;

use AlibabaCloud\Client\Exception\ClientException;
use Exception;

/**
 * Use the RSA key pair to complete the authentication (supported only on Japanese site)
 *
 * @package   AlibabaCloud\Client\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/aliyun-openapi-php-sdk
 */
class RsaKeyPairCredential implements CredentialsInterface
{

    /**
     * @var string
     */
    private $publicKeyId;
    /**
     * @var string
     */
    private $privateKey;

    /**
     * RsaKeyPairCredential constructor.
     *
     * @param string $publicKeyId
     * @param string $privateKeyFile
     *
     * @throws ClientException
     */
    public function __construct($publicKeyId, $privateKeyFile)
    {
        $this->publicKeyId = $publicKeyId;
        try {
            $this->privateKey = file_get_contents($privateKeyFile);
        } catch (Exception $exception) {
            throw new ClientException($exception->getMessage(), \ALI_INVALID_CREDENTIAL);
        }
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getPublicKeyId()
    {
        return $this->publicKeyId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "publicKeyId#$this->publicKeyId";
    }
}
