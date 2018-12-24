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
 * Class VirtualRamRoleArnCredential
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
class VirtualRamRoleArnCredential extends VirtualAccessKeyCredential
{

    /**
     * @return string
     */
    public static function noKey()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
role_arn = role_arn
role_session_name = role_session_name
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
type = ram_role_arn
access_key_id = access_key_id
role_arn = role_arn
role_session_name = role_session_name
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noRoleArn()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
access_key_id = access_key_id
access_key_secret = access_key_secret
role_session_name = role_session_name
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noRoleSessionName()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = ram_role_arn
access_key_id = access_key_id
access_key_secret = access_key_secret
role_arn = role_arn
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
type = ram_role_arn
access_key_id = access_key_id
access_key_secret = access_key_secret
role_arn = role_arn
role_session_name = role_session_name
EOT;
        return (new static($content))->url();
    }
}
