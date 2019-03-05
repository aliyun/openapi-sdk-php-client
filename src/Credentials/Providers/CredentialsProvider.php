<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use Closure;

/**
 * Class CredentialsProvider
 *
 * @package AlibabaCloud\Client\Credentials\Providers
 */
class CredentialsProvider
{
    /**
     * @var array
     */
    private static $hasCustomChain;

    /**
     * @throws ClientException
     */
    public static function chain()
    {
        $providers = func_get_args();

        if (empty($providers)) {
            throw new ClientException('No providers in chain', \ALIBABA_CLOUD_INVALID_ARGUMENT);
        }

        foreach ($providers as $provider) {
            if (!$provider instanceof Closure) {
                throw new ClientException('Providers must all be Closures', \ALIBABA_CLOUD_INVALID_ARGUMENT);
            }
        }

        self::$hasCustomChain = $providers;
    }

    public static function flush()
    {
        self::$hasCustomChain = [];
    }

    /**
     * @return bool
     */
    public static function hasCustomChain()
    {
        return (bool)self::$hasCustomChain;
    }

    /**
     * @param string $clientName
     *
     * @throws ClientException
     */
    public static function customProvider($clientName)
    {
        foreach (self::$hasCustomChain as $provider) {
            $provider();
            if (AlibabaCloud::has($clientName)) {
                break;
            }
        }
    }

    /**
     * @param string $clientName
     *
     * @throws ClientException
     */
    public static function defaultProvider($clientName)
    {
        $providers = [
            self::env(),
            self::ini(),
            self::instance(),
        ];

        foreach ($providers as $provider) {
            $provider();
            if (AlibabaCloud::has($clientName)) {
                break;
            }
        }
    }

    /**
     * @return Closure
     */
    public static function env()
    {
        return function () {
            $accessKeyId     = \AlibabaCloud\Client\envNotEmpty('ALIBABA_CLOUD_ACCESS_KEY_ID');
            $accessKeySecret = \AlibabaCloud\Client\envNotEmpty('ALIBABA_CLOUD_ACCESS_KEY_SECRET');

            if ($accessKeyId && $accessKeySecret) {
                AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->asDefaultClient();
            }
        };
    }

    /**
     * @return Closure
     */
    public static function ini()
    {
        return function () {
            $ini = \AlibabaCloud\Client\envNotEmpty('ALIBABA_CLOUD_CREDENTIALS_FILE');

            if ($ini) {
                AlibabaCloud::load($ini);
            } else {
                AlibabaCloud::load();
            }

            self::compatibleWithGlobal();
        };
    }

    /**
     * @codeCoverageIgnore
     *
     * Compatible with global
     *
     * @throws ClientException
     */
    private static function compatibleWithGlobal()
    {
        if (AlibabaCloud::has('global') && !AlibabaCloud::has(self::getDefaultName())) {
            AlibabaCloud::get('global')->name(self::getDefaultName());
        }
    }

    /**
     * @return Closure
     */
    public static function instance()
    {
        return function () {
            $instance = \AlibabaCloud\Client\envNotEmpty('ALIBABA_CLOUD_ECS_METADATA');
            if ($instance) {
                AlibabaCloud::ecsRamRoleClient($instance)->asDefaultClient();
            }
        };
    }

    /**
     * @return array|false|string
     * @throws ClientException
     */
    public static function getDefaultName()
    {
        $name = \AlibabaCloud\Client\envNotEmpty('ALIBABA_CLOUD_PROFILE');

        if ($name) {
            return $name;
        }

        return 'default';
    }
}
