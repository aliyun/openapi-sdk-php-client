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

namespace AlibabaCloud\Client\Http;

use AlibabaCloud\Client\Clients\Client;

/**
 * Class GuzzleTrait
 *
 * @package   AlibabaCloud\Client\Http
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin     Client
 */
trait GuzzleTrait
{

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string|null
     */
    public $regionId;

    /**
     * @param string $region
     *
     * @return self
     */
    public function regionId($region)
    {
        $this->regionId = $region;
        return $this;
    }

    /**
     * @param int|float $timeout
     *
     * @return self
     */
    public function timeout($timeout)
    {
        $this->options['timeout'] = $timeout;
        return $this;
    }

    /**
     * @param int|float $connectTimeout
     *
     * @return self
     */
    public function connectTimeout($connectTimeout)
    {
        $this->options['connect_timeout'] = $connectTimeout;
        return $this;
    }

    /**
     * @param bool $debug
     *
     * @return self
     */
    public function debug($debug)
    {
        $this->options['debug'] = $debug;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param array $cert
     *
     * @return self
     */
    public function cert($cert)
    {
        $this->options['cert'] = $cert;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param array|string $proxy
     *
     * @return self
     */
    public function proxy($proxy)
    {
        $this->options['proxy'] = $proxy;
        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function options(array $options)
    {
        if ($options !== []) {
            $this->options = \AlibabaCloud\Client\arrayMerge([$this->options, $options]);
        }
        return $this;
    }
}
