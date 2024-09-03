<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use Exception;
use ReflectionException;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStreamFile;
use AlibabaCloud\Client\Config\Config;
use clagiordano\weblibs\configmanager\ConfigManager;

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
     * @after
     * @throws ReflectionException
     */
    protected function finalize()
    {
        parent::tearDown();
        self::setStaticProperty(null);
    }

    /**
     * @param $value
     *
     * @throws ReflectionException
     */
    private static function setStaticProperty($value)
    {
        $ref = new \ReflectionClass(Config::class);
        $property = $ref->getProperty('configManager');
        $property->setAccessible(true);
        $property->setValue($value);
        
    }

    /**
     * @throws ReflectionException
     */
    public function testGetConfigManager()
    {
        $ref = new \ReflectionClass(Config::class);
        $method = $ref->getMethod('getConfigManager');
        $method->setAccessible(true);
        self::assertInstanceOf(ConfigManager::class, $method->invoke(null));
        
    }

    /**
     * @depends testGetConfigManager
     * @throws  ReflectionException
     * @throws Exception
     */
    public function testSetAndGet()
    {
        self::setStaticProperty(new ConfigManager(self::file()->url()));
        Config::set('vfs', __METHOD__);
        self::assertEquals(Config::get('vfs'), __METHOD__);
        
    }

    /**
     * @return vfsStreamFile|string
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

        $root = vfsStream::setup('AlibabaCloud');
        self::$vfs = vfsStream::newFile('config')
            ->withContent($content)
            ->at($root);

        return self::$vfs;
        
    }
}
