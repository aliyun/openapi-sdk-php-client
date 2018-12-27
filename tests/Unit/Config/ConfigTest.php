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

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Config\Config;
use clagiordano\weblibs\configmanager\ConfigManager;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

/**
 * Class AccessKeyCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class ConfigTest extends TestCase
{

    /**
     * @var string
     */
    private static $vfs;

    /**
     * Restore static attribute.
     *
     * @throws \ReflectionException
     */
    public function tearDown()
    {
        parent::tearDown();
        self::setStaticProperty(null);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetConfigManager()
    {
        $ref    = new \ReflectionClass(Config::class);
        $method = $ref->getMethod('getConfigManager');
        $method->setAccessible(true);
        self::assertInstanceOf(ConfigManager::class, $method->invoke(null));
    }

    /**
     * @depends testGetConfigManager
     * @throws  \ReflectionException
     */
    public function testSetAndGet()
    {
        self::setStaticProperty(new ConfigManager(self::file()->url()));
        Config::set('vfs', __METHOD__);
        self::assertEquals(Config::get('vfs'), __METHOD__);
    }

    /**
     * @return \org\bovigo\vfs\vfsStreamFile|string
     */
    private static function file()
    {
        if (self::$vfs !== null) {
            return self::$vfs;
        }

        $content = <<<EOT
<?php

return [];
EOT;

        $root      = vfsStream::setup('AlibabaCloud');
        self::$vfs = vfsStream::newFile('config')
                              ->withContent($content)
                              ->at($root);
        return self::$vfs;
    }

    /**
     * @param $value
     *
     * @throws \ReflectionException
     */
    private static function setStaticProperty($value)
    {
        $ref      = new \ReflectionClass(Config::class);
        $property = $ref->getProperty('configManager');
        $property->setAccessible(true);
        $property->setValue($value);
    }
}
