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

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use AlibabaCloud\Client\Exception\ClientException;
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
     * @covers ::__construct
     * @covers ::getDefaultFile
     * @covers ::getFilename
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
     * @throws \ReflectionException
     */
    public function testIsNotEmpty($array, $key, $bool)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionClass(
            IniCredential::class
        );
        $method = $ref->getMethod('isNotEmpty');
        $method->setAccessible(true);
        $result = $method->invokeArgs($object, [$array, $key]);
        self::assertEquals($result, $bool);
    }

    /**
     * @return array
     */
    public function isNotEmpty()
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessageRegExp /Missing required 'key' option for 'name'/
     */
    public function testMissingRequired()
    {
        $object = new IniCredential();
        $object->missingRequired('key', 'name');
    }

    /**
     * @throws ClientException
     * @throws \ReflectionException
     */
    public function testForgetLoadedCredentialsFile()
    {
        IniCredential::forgetLoadedCredentialsFile();

        $ref        = new \ReflectionClass(IniCredential::class);
        $properties = $ref->getStaticProperties();
        self::assertEquals([], $properties['hasLoaded']);

        AlibabaCloud::load(VirtualAccessKeyCredential::ok());

        $ref        = new \ReflectionClass(IniCredential::class);
        $properties = $ref->getStaticProperties();
        self::assertArrayHasKey(VirtualAccessKeyCredential::ok(), $properties['hasLoaded']);

        IniCredential::forgetLoadedCredentialsFile();
        $ref        = new \ReflectionClass(IniCredential::class);
        $properties = $ref->getStaticProperties();
        self::assertEquals([], $properties['hasLoaded']);
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
     * @throws \ReflectionException
     */
    public function testLoadFile($fileName)
    {
        $object = new IniCredential($fileName);
        $method = new \ReflectionMethod(
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
     * @throws \ReflectionException
     * @dataProvider parseFile
     */
    public function testParseFile($fileName, $exceptionMessage)
    {
        $object = new IniCredential($fileName);
        $method = new \ReflectionMethod(
            IniCredential::class,
            'parseFile'
        );
        $method->setAccessible(true);
        try {
            $result = $method->invoke($object);
            self::assertInternalType('array', $result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $exception->getErrorMessage(),
                $exceptionMessage
            );
        }
    }

    /**
     * Independent method, the file must exist.
     *
     * @return array
     */
    public function parseFile()
    {
        return [
            [
                VirtualAccessKeyCredential::badFormat(),
                'Format error: vfs://AlibabaCloud/credentials',
            ],
            [
                '/no/no.no',
                'parse_ini_file(/no/no.no): failed to open stream: No such file or directory',
            ],
        ];
    }

    /**
     * @throws \ReflectionException
     * @covers ::getHomeDirectory
     * @depends testParseFile
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
     * @depends testGetsHomeDirectoryForWindowsUser
     */
    public function testGetsHomeDirectoryForLinuxUser()
    {
        putenv('HOME=/root');
        putenv('HOMEDRIVE=');
        putenv('HOMEPATH=');
        $ref    = new \ReflectionClass(IniCredential::class);
        $method = $ref->getMethod('getHomeDirectory');
        $method->setAccessible(true);
        $this->assertEquals('/root', $method->invoke(null));
    }
}
