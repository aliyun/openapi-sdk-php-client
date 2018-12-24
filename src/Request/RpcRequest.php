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
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/client-php
 *
 */

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class RpcRequest
 *
 * @package AlibabaCloud\Client\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/client-php
 */
class RpcRequest extends Request
{

    /**
     * @var string
     */
    private $dateTimeFormat = 'Y-m-d\TH:i:s\Z';

    /**
     * RpcRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->method('GET');
        $this->format('JSON');
        parent::__construct($options);
    }

    /**
     * @param bool|string $value
     *
     * @return string
     */
    private function prepareValue($value)
    {
        if (is_bool($value)) {
            if ($value) {
                return 'true';
            }

            return 'false';
        }
        return $value;
    }

    /**
     * @param AccessKeyCredential|BearerTokenCredential|CredentialsInterface $credential
     *
     * @throws ClientException
     */
    public function preparationParameters($credential)
    {
        if (isset($this->options['query'])) {
            foreach ($this->options['query'] as $key => $value) {
                $this->options['query'][$key] = $this->prepareValue($value);
            }
        }
        $this->options['query']['RegionId']         = $this->realRegionId();
        $this->options['query']['AccessKeyId']      = $credential->getAccessKeyId();
        $this->options['query']['Format']           = $this->format;
        $this->options['query']['SignatureMethod']  = $this->httpClient()->getSignature()->getMethod();
        $this->options['query']['SignatureVersion'] = $this->httpClient()->getSignature()->getVersion();
        if ($this->httpClient()->getSignature()->getType() !== '') {
            $this->options['query']['SignatureType'] = $this->httpClient()->getSignature()->getType();
        }
        $this->options['query']['SignatureNonce'] = md5(uniqid(mt_rand(), true));
        $this->options['query']['Timestamp']      = gmdate($this->dateTimeFormat);
        $this->options['query']['Action']         = $this->action;
        $this->options['query']['Version']        = $this->version;
        if ($credential instanceof StsCredential) {
            $this->options['query']['SecurityToken'] = $credential->getSecurityToken();
        }
        if ($credential instanceof BearerTokenCredential) {
            $this->options['query']['BearerToken'] = $credential->getBearerToken();
        }

        $this->options['query']['Signature'] =
            $this->computeSignature($this->options['query'], $credential->getAccessKeySecret());

        /**----------------------------------------------------------------
         *   POST Method
         *---------------------------------------------------------------*/
        if ($this->method === 'POST') {
            foreach ($this->options['query'] as $apiParamKey => $apiParamValue) {
                $this->options['form_params'][$apiParamKey] = $apiParamValue;
            }
            unset($this->options['query']);
        }

        $this->uri = $this->protocol . '://' . $this->domain . '/';
    }

    /**
     * @param array  $parameters
     * @param string $accessKeySecret
     *
     * @return mixed
     * @throws ClientException
     */
    private function computeSignature($parameters, $accessKeySecret)
    {
        ksort($parameters);
        $canonicalizedQuery = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQuery .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }
        $stringToSign = $this->method . '&%2F&' . $this->percentEncode(substr($canonicalizedQuery, 1));
        return $this->httpClient()->getSignature()->sign($stringToSign, $accessKeySecret . '&');
    }

    /**
     * @param string $str
     *
     * @return null|string|string[]
     */
    protected function percentEncode($str)
    {
        $res = urlencode($str);
        $res = str_replace(['+', '*'], ['%20', '%2A'], $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }

    /**
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (\strpos($name, 'get', 0) !== false) {
            return $this->__get($this->propertyNameByMethodName($name));
        }
        if (\strpos($name, 'set', 0) !== false) {
            $this->__set($this->propertyNameByMethodName($name), $arguments[0]);
        }
        return $this;
    }

    /**
     * When get a property that does not exist, it can be understood as a custom request parameter.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->options['query'][$name])
            ? $this->options['query'][$name]
            : null;
    }

    /**
     * When set a property that does not exist, it can be understood as a custom request parameter.
     *
     * @param string $name
     * @param        $value
     */
    public function __set($name, $value)
    {
        $this->options['query'][$name] = $value;
    }

    /**
     * When accessing a property that does not exist, it can be understood as a custom request parameter.
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->options['query'][$name]);
    }
}
