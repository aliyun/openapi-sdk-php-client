<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

use AlibabaCloud\Client\Clients\AccessKeyClient;
use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 */
class CreateTraitTest extends TestCase
{

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @param string $errorMessage
     *
     * @throws       \ReflectionException
     * @dataProvider createClient
     */
    public function testCreateClient($clientName, array $credential, $errorMessage)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionMethod(
            IniCredential::class,
            'createClient'
        );
        $ref->setAccessible(true);
        try {
            $result = $ref->invokeArgs($object, [$clientName, $credential]);
            self::assertFalse($result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $errorMessage . ' in ' . $object->getFilename(),
                $exception->getErrorMessage()
            );
        }
    }

    /**
     * @return array
     */
    public function createClient()
    {
        return [
            [
                'disable',
                [
                ],
                false,
            ],
            [
                'enable',
                [
                    'enable' => true,
                ],
                "Missing required 'type' option for 'enable'",
            ],
            [
                'enable',
                [
                    'enable' => true,
                    'type'   => 'badType',
                ],
                "Invalid type 'badType' for 'enable'",
            ],
        ];
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @param string $errorMessage
     *
     * @throws       \ReflectionException
     * @dataProvider createClientByType
     */
    public function testCreateClientByType($clientName, array $credential, $errorMessage)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionMethod(
            IniCredential::class,
            'createClientByType'
        );
        $ref->setAccessible(true);
        try {
            $ref->invokeArgs($object, [$clientName, $credential]);
        } catch (ClientException $exception) {
            self::assertEquals(
                $errorMessage . ' in ' . $object->getFilename(),
                $exception->getErrorMessage()
            );
        }
    }

    /**
     * @return array
     */
    public function createClientByType()
    {
        return [
            [
                'access_key',
                [
                    'type' => 'access_key',
                ],
                "Missing required 'access_key_id' option for 'access_key'",
            ],
            [
                'ecs_ram_role',
                [
                    'type' => 'ecs_ram_role',
                ],
                "Missing required 'role_name' option for 'ecs_ram_role'",
            ],
            [
                'ram_role_arn',
                [
                    'type' => 'ram_role_arn',
                ],
                "Missing required 'access_key_id' option for 'ram_role_arn'",
            ],
            [
                'bearer_token',
                [
                    'type' => 'bearer_token',
                ],
                "Missing required 'bearer_token' option for 'bearer_token'",
            ],
            [
                'rsa_key_pair',
                [
                    'type' => 'rsa_key_pair',
                ],
                "Missing required 'public_key_id' option for 'rsa_key_pair'",
            ],
            [
                'enable',
                [
                    'enable' => true,
                    'type'   => 'badType',
                ],
                "Invalid type 'badType' for 'enable'",
            ],
        ];
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @param string $errorMessage
     *
     * @throws       \ReflectionException
     * @dataProvider rsaKeyPairClient
     */
    public function testRsaKeyPairClient($clientName, array $credential, $errorMessage)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionMethod(
            IniCredential::class,
            'rsaKeyPairClient'
        );
        $ref->setAccessible(true);
        try {
            $result = $ref->invokeArgs($object, [$clientName, $credential]);
            self::assertInstanceOf(RsaKeyPairClient::class, $result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $errorMessage . ' in ' . $object->getFilename(),
                $exception->getErrorMessage()
            );
        }
    }

    /**
     * @return array
     */
    public function rsaKeyPairClient()
    {
        return [
            [
                'enable',
                [
                ],
                "Missing required 'public_key_id' option for 'enable'",
            ],
            [
                'enable',
                [
                    'public_key_id' => 'id',
                    'type'          => 'rsa_key_pair',
                ],
                "Missing required 'private_key_file' option for 'enable'",
            ],
            [
                'enable',
                [
                    'public_key_id'    => 'id',
                    'private_key_file' => __FILE__,
                ],
                'success',
            ],
        ];
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @param string $errorMessage
     *
     * @throws       \ReflectionException
     * @dataProvider accessKeyClient
     */
    public function testAccessKeyClient($clientName, array $credential, $errorMessage)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionMethod(
            IniCredential::class,
            'accessKeyClient'
        );
        $ref->setAccessible(true);
        try {
            $result = $ref->invokeArgs($object, [$clientName, $credential]);
            self::assertInstanceOf(AccessKeyClient::class, $result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $errorMessage . ' in ' . $object->getFilename(),
                $exception->getErrorMessage()
            );
        }
    }

    /**
     * @return array
     */
    public function accessKeyClient()
    {
        return [
            [
                'no_access_key_id',
                [
                ],
                "Missing required 'access_key_id' option for 'no_access_key_id'",
            ],
            [
                'no_access_key_secret',
                [
                    'access_key_id' => 'id',
                ],
                "Missing required 'access_key_secret' option for 'no_access_key_secret'",
            ],
            [
                'success',
                [
                    'access_key_id'     => 'foo',
                    'access_key_secret' => 'bar',
                ],
                'success',
            ],
        ];
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @param string $errorMessage
     *
     * @dataProvider ecsRamRoleClient
     *
     * @throws \ReflectionException
     */
    public function testEcsRamRoleClient($clientName, array $credential, $errorMessage)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionMethod(
            IniCredential::class,
            'ecsRamRoleClient'
        );
        $ref->setAccessible(true);
        try {
            $result = $ref->invokeArgs($object, [$clientName, $credential]);
            self::assertInstanceOf(EcsRamRoleClient::class, $result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $errorMessage . ' in ' . $object->getFilename(),
                $exception->getErrorMessage()
            );
        }
    }

    /**
     * @return array
     */
    public function ecsRamRoleClient()
    {
        return [
            [
                'no_role_name',
                [
                ],
                "Missing required 'role_name' option for 'no_role_name'",
            ],
            [
                'ok',
                [
                    'role_name' => 'foo',
                ],
                'success',
            ],
        ];
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @param string $errorMessage
     *
     * @dataProvider ramRoleArnClient
     *
     * @throws \ReflectionException
     */
    public function testRamRoleArnClient($clientName, array $credential, $errorMessage)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionMethod(
            IniCredential::class,
            'ramRoleArnClient'
        );
        $ref->setAccessible(true);
        try {
            $result = $ref->invokeArgs($object, [$clientName, $credential]);
            self::assertInstanceOf(RamRoleArnClient::class, $result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $errorMessage . ' in ' . $object->getFilename(),
                $exception->getErrorMessage()
            );
        }
    }

    /**
     * @return array
     */
    public function ramRoleArnClient()
    {
        return [
            [
                'no_access_key_id',
                [
                ],
                "Missing required 'access_key_id' option for 'no_access_key_id'",
            ],
            [
                'no_access_key_secret',
                [
                    'access_key_id' => 'foo',
                ],
                "Missing required 'access_key_secret' option for 'no_access_key_secret'",
            ],
            [
                'no_role_arn',
                [
                    'access_key_id'     => 'foo',
                    'access_key_secret' => 'bar',
                ],
                "Missing required 'role_arn' option for 'no_role_arn'",
            ],
            [
                'no_role_session_name',
                [
                    'access_key_id'     => 'foo',
                    'access_key_secret' => 'bar',
                    'role_arn'          => 'role_arn',
                ],
                "Missing required 'role_session_name' option for 'no_role_session_name'",
            ],
            [
                'ok',
                [
                    'access_key_id'     => 'foo',
                    'access_key_secret' => 'bar',
                    'role_arn'          => 'role_arn',
                    'role_session_name' => 'role_session_name',
                ],
                'success',
            ],
        ];
    }

    /**
     * @param string $clientName
     * @param array  $credential
     *
     * @param string $errorMessage
     *
     * @dataProvider bearerTokenClient
     *
     * @throws \ReflectionException
     */
    public function testBearerTokenClient($clientName, array $credential, $errorMessage)
    {
        $object = new IniCredential();
        $ref    = new \ReflectionMethod(
            IniCredential::class,
            'bearerTokenClient'
        );
        $ref->setAccessible(true);
        try {
            $result = $ref->invokeArgs($object, [$clientName, $credential]);
            self::assertInstanceOf(BearerTokenClient::class, $result);
        } catch (ClientException $exception) {
            self::assertEquals(
                $errorMessage . ' in ' . $object->getFilename(),
                $exception->getErrorMessage()
            );
        }
    }

    /**
     * @return array
     */
    public function bearerTokenClient()
    {
        return [
            [
                'no_bearer_token',
                [
                ],
                "Missing required 'bearer_token' option for 'no_bearer_token'",
            ],
            [
                'ok',
                [
                    'bearer_token' => 'token',
                ],
                'success',
            ],
        ];
    }
}
