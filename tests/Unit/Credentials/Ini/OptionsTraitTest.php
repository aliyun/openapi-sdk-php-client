<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class OptionsTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class OptionsTraitTest extends TestCase
{

    /**
     * @param array $configures
     *
     * @param mixed $expectedCert
     *
     * @throws       \ReflectionException
     * @dataProvider setCert
     */
    public function testSetCert(array $configures, $expectedCert)
    {
        // Setup
        $client = new EcsRamRoleClient('test');
        $object = new IniCredential();
        $ref    = new \ReflectionClass(IniCredential::class);
        $method = $ref->getMethod('setCert');
        $method->setAccessible(true);

        $method->invokeArgs($object, [$configures, $client]);
        self::assertEquals($expectedCert, $client->options['cert']);
    }

    /**
     * @return array
     */
    public function setCert()
    {
        return [
            [
                [
                    'cert_file' => '/file/file.pem',
                ],
                '/file/file.pem',
            ],
            [
                [
                    'cert_file'     => '/file/file.pem',
                    'cert_password' => 'password',
                ],
                [
                    '/file/file.pem',
                    'password',
                ],
            ],
        ];
    }
}
