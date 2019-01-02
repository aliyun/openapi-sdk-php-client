<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Config\Config;
use clagiordano\weblibs\configmanager\ConfigManager;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

/**
 * Class AccessKeyCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
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
