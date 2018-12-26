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

use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class IniCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Ini\IniCredential
 */
class IniCredentialTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @throws \ReflectionException
     * @covers ::getHomeDirectory
     */
    public function testGetsHomeDirectoryForWindowsUser()
    {
        putenv('HOME=');
        putenv('HOMEDRIVE=C:');
        putenv('HOMEPATH=\\Users\\Alibaba');
        $ref    = new \ReflectionClass(IniCredential::class);
        $method = $ref->getMethod('getHomeDirectory');
        $method->setAccessible(true);
        $this->assertEquals('C:\\Users\\Alibaba', $method->invoke(null));
    }

    /**
     * @throws \ReflectionException
     * @covers ::getHomeDirectory
     */
    public function testGetsHomeDirectoryForLinuxUser()
    {
        putenv('HOME=/root/');
        putenv('HOMEDRIVE=');
        putenv('HOMEPATH=');
        $ref    = new \ReflectionClass(IniCredential::class);
        $method = $ref->getMethod('getHomeDirectory');
        $method->setAccessible(true);
        $this->assertEquals('/root/', $method->invoke(null));
    }
}
