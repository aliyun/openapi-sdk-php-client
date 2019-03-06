<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class IniCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\Ini\IniCredential
 */
class IniCredentialTest extends TestCase
{
    /**
     * @return array
     */
    public static function isNotEmpty()
    {
        return [
            [
                [],
                'key',
                false,
            ],
            [
                [
                    'key' => '',
                ],
                'key',
                false,
            ],
            [
                [
                    'key' => 'false',
                ],
                'key',
                true,
            ],
            [
                [
                    'key' => true,
                ],
                'key',
                true,
            ],
            [
                [
                    'key' => 'value',
                ],
                'key',
                true,
            ],
        ];
    }

    /**
     * @throws ClientException
     */
    public static function testInOpenBaseDir()
    {
        if (!\AlibabaCloud\Client\isWindows()) {
            $dirs = 'vfs://AlibabaCloud:/home:/Users:/private:/a/b:/d';
            ini_set('open_basedir', $dirs);
            self::assertEquals($dirs, ini_get('open_basedir'));
            self::assertTrue(\AlibabaCloud\Client\inOpenBasedir('/Users/alibabacloud'));
            self::assertTrue(\AlibabaCloud\Client\inOpenBasedir('/private/alibabacloud'));
            self::assertFalse(\AlibabaCloud\Client\inOpenBasedir('/no/permission'));
            self::assertFalse(\AlibabaCloud\Client\inOpenBasedir('/a'));
            self::assertTrue(\AlibabaCloud\Client\inOpenBasedir('/a/b/'));
            self::assertTrue(\AlibabaCloud\Client\inOpenBasedir('/a/b/c'));
            self::assertFalse(\AlibabaCloud\Client\inOpenBasedir('/b'));
            self::assertFalse(\AlibabaCloud\Client\inOpenBasedir('/b/'));
            self::assertFalse(\AlibabaCloud\Client\inOpenBasedir('/x/d/c.txt'));
            self::assertFalse(\AlibabaCloud\Client\inOpenBasedir('/a/b.php'));
        }
        if (\AlibabaCloud\Client\isWindows()) {
            $dirs = 'C:\\projects;C:\\Users';
            ini_set('open_basedir', $dirs);
            self::assertEquals($dirs, ini_get('open_basedir'));
        }
    }

    /**
     * Independent method, the file must exist.
     *
     * @return array
     */
    public static function parseFile()
    {
        return [
            [
                VirtualAccessKeyCredential::ok(),
                'Format error: vfs://AlibabaCloud/credentials',
            ],
        ];
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @covers       ::__construct
     * @covers       ::getDefaultFile
     * @covers       ::getFilename
     * @dataProvider getFilename
     *
     * @param string $fileName
     * @param string $getFileName
     */
    public function testGetFilename($fileName, $getFileName)
    {
        $object = new IniCredential($fileName);
        self::assertEquals($getFileName, $object->getFilename());
    }

    /**
     * @return array
     */
    public function getFilename()
    {
        return [
            [
                '',
                (new IniCredential())->getDefaultFile(),
            ],
            [
                '/no/no/no',
                '/no/no/no',
            ],
        ];
    }

    /**
     * @dataProvider isNotEmpty
     *
     * @param array  $array
     * @param string $key
     * @param bool   $bool
     *
     * @throws ReflectionException
     */
    public function testIsNotEmpty($array, $key, $bool)
    {
        $object = new IniCredential();
        $ref    = new ReflectionClass(
            IniCredential::class
        );
        $method = $ref->getMethod('isNotEmpty');
        $method->setAccessible(true);
        $result = $method->invokeArgs($object, [$array, $key]);
        self::assertEquals($result, $bool);
    }

    /**
     * @expectedException              \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /Missing required 'key' option for 'name'/
     */
    public function testMissingRequired()
    {
        $object = new IniCredential();
        $object->missingRequired('key', 'name');
    }

    /**
     * @throws ReflectionException
     */
    public function testForgetLoadedCredentialsFile()
    {
        $reflectedClass    = new ReflectionClass(IniCredential::class);
        $reflectedProperty = $reflectedClass->getProperty('hasLoaded');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue([
                                         'FILE' => 'FILE',
                                     ]);
        self::assertArrayHasKey('FILE', $reflectedClass->getStaticProperties()['hasLoaded']);

        IniCredential::forgetLoadedCredentialsFile();

        self::assertEquals([], $reflectedClass->getStaticProperties()['hasLoaded']);
    }

    /**
     * @throws ClientException
     */
    public function testLoad()
    {
        $object = new IniCredential(VirtualAccessKeyCredential::ok());
        self::assertEquals($object->load(), $object->load());
    }

    /**
     * @dataProvider loadFile
     *
     * @param string $fileName
     *
     * @throws ReflectionException
     */
    public function testLoadFile($fileName)
    {
        $object = new IniCredential($fileName);
        $method = new ReflectionMethod(
            IniCredential::class,
            'loadFile'
        );
        $method->setAccessible(true);
        try {
            $result = $method->invoke($object);
            self::assertInternalType('array', $result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $exception->getErrorMessage(),
                'Credential file is not readable: /no/no.no'
            );
        }
    }

    /**
     * @return array
     */
    public function loadFile()
    {
        return [
            [''],
            ['/no/no.no'],
        ];
    }

    /**
     * @param string $fileName
     * @param string $exceptionMessage
     *
     * @throws       ReflectionException
     * @dataProvider parseFile
     */
    public function testParseFile($fileName, $exceptionMessage)
    {
        $object = new IniCredential($fileName);
        $method = new ReflectionMethod(
            IniCredential::class,
            'parseFile'
        );
        $method->setAccessible(true);
        try {
            self::assertArrayHasKey('ok', $method->invoke($object));
        } catch (ClientException $exception) {
            self::assertEquals(
                $exception->getErrorMessage(),
                $exceptionMessage
            );
        }
    }

    /**
     * @throws       ReflectionException
     * @dataProvider parseFile
     */
    public function testParseFileBadFormat()
    {
        $object = new IniCredential(VirtualAccessKeyCredential::badFormat());
        $method = new ReflectionMethod(
            IniCredential::class,
            'parseFile'
        );
        $method->setAccessible(true);
        try {
            self::assertArrayHasKey('ok', $method->invoke($object));
        } catch (ClientException $exception) {
            self::assertEquals(
                $exception->getErrorMessage(),
                'Format error: vfs://AlibabaCloud/credentials-badFormat'
            );
        }
    }

    /**
     * @throws  ReflectionException
     * @covers  ::getHomeDirectory
     * @depends testParseFile
     */
    public function testGetsHomeDirectoryForWindowsUser()
    {
        putenv('HOME=');
        putenv('HOMEDRIVE=C:');
        putenv('HOMEPATH=\\Users\\Alibaba');
        $ref    = new ReflectionClass(IniCredential::class);
        $method = $ref->getMethod('getHomeDirectory');
        $method->setAccessible(true);
        $this->assertEquals('C:\\Users\\Alibaba', $method->invoke(null));
    }

    /**
     * @throws  ReflectionException
     * @covers  ::getHomeDirectory
     * @depends testGetsHomeDirectoryForWindowsUser
     */
    public function testGetsHomeDirectoryForLinuxUser()
    {
        putenv('HOME=/root');
        putenv('HOMEDRIVE=');
        putenv('HOMEPATH=');
        $ref    = new ReflectionClass(IniCredential::class);
        $method = $ref->getMethod('getHomeDirectory');
        $method->setAccessible(true);
        $this->assertEquals('/root', $method->invoke(null));
    }
}
