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

use org\bovigo\vfs\vfsStream;

/**
 * Class VirtualAccessKeyCredential
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
class VirtualAccessKeyCredential
{

    /**
     * @var string Virtual Credential Content
     */
    private $content;

    /**
     * VirtualCredential constructor.
     *
     * @param $content
     */
    protected function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return string Virtual Credential Filename
     */
    public function url()
    {
        $root = vfsStream::setup('AlibabaCloud');
        return vfsStream::newFile('credentials')
                        ->withContent($this->content)
                        ->at($root)
                        ->url();
    }

    /**
     * @param string $clineName
     *
     * @return string
     */
    public static function akClientWithAttributes($clineName = 'phpunit')
    {
        $content = <<<EOT
[{$clineName}]
enable = true
type = access_key
access_key_id = access_key_id
access_key_secret = access_key_secret
security_token = security_token
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

    /**
     * @param string $clineName
     *
     * @return string
     */
    public static function akClientWithAttributesNoCertPassword($clineName = 'phpunit')
    {
        $content = <<<EOT
[{$clineName}]
enable = true
type = access_key
access_key_id = access_key_id
access_key_secret = access_key_secret
security_token = security_token
debug = true
delay = 3.2
timeout = 3.2
connect_timeout = 3.2
cert_file = /path/server.pem
proxy = tcp://localhost:8125
proxy_http = tcp://localhost:8125
proxy_https = tcp://localhost:9124
proxy_no = .mit.edu,foo.com
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noType()
    {
        $content = <<<EOT
[phpunit]
enable = true
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noSecret()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = access_key
access_key_id = access_key_id
security_token = security_token
debug = false
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function badFormat()
    {
        $content = <<<EOT
badFormat
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function disable()
    {
        $content = <<<EOT
[phpunit]
enable = false
type = access_key
access_key_id = access_key_id
access_key_secret = access_key_secret
security_token = security_token
debug = false
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function invalidType()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = invalidType
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noKey()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = access_key
access_key_secret = access_key_secret
security_token = security_token
debug = false
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function ok()
    {
        $content = <<<EOT
[ok]
enable = true
type = access_key
access_key_id = foo
access_key_secret = bar
region_id = cn-hangzhou
debug = true
timeout = 0.2
connect_Timeout = 0.03
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
