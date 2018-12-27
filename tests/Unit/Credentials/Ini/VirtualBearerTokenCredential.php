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

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

/**
 * Class VirtualBearerTokenCredential
 *
 * @codeCoverageIgnore
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class VirtualBearerTokenCredential extends VirtualAccessKeyCredential
{

    /**
     * @return string
     */
    public static function noToken()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = bearer_token
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function client()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = bearer_token
bearer_token = bearer_token
region_id = cn-hangzhou
debug = true
delay = 3.2
timeout = 3.2
connect_timeout = 3.2
cert_file = /path/server.pem
cert_password = password
proxy = tcp://localhost:8125
proxy_http = tcp://localhost:8125
proxy_https = tcp://localhost:9124
proxy_no = .mit.edu,foo.com
EOT;
        return (new static($content))->url();
    }
}
