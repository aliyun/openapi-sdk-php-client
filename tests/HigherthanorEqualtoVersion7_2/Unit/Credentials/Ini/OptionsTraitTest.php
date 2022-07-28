<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini;

use ReflectionClass;
use ReflectionException;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;

/**
 * Class OptionsTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini
 */
class OptionsTraitTest extends TestCase
{

    /**
     * @param array $configures
     *
     * @param mixed $expectedCert
     *
     * @throws       ReflectionException
     * @throws ClientException
     * @dataProvider setCert
     */
    public function testSetCert(array $configures, $expectedCert)
    {
        // Setup
        $client = new EcsRamRoleClient('test');
        $object = new IniCredential();
        $ref    = new ReflectionClass(IniCredential::class);
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
