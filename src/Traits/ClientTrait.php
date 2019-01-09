<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\AccessKeyClient;
use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Clients\StsClient;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\SignatureInterface;

/**
 * Trait of the manage clients.
 *
 * @package   AlibabaCloud\Client\Traits
 *
 * @mixin     AlibabaCloud
 */
trait ClientTrait
{
    /**
     * @var array Containers of Clients
     */
    protected static $clients = [];

    /**
     * Get the Client instance by name.
     *
     * @param string $clientName
     *
     * @return Client
     * @throws ClientException
     */
    public static function get($clientName)
    {
        if (self::has($clientName)) {
            return self::$clients[\strtolower($clientName)];
        }
        throw new ClientException(
            "Client not found: $clientName",
            \ALIBABA_CLOUD_CLIENT_NOT_FOUND
        );
    }

    /**
     * @param string $clientName
     * @param Client $client
     *
     * @return Client
     */
    public static function set($clientName, Client $client)
    {
        return self::$clients[\strtolower($clientName)] = $client;
    }

    /**
     * Get all clients.
     *
     * @return array
     */
    public static function all()
    {
        return self::$clients;
    }

    /**
     * Delete the client by specifying name.
     *
     * @param string $name
     */
    public static function del($name)
    {
        unset(self::$clients[\strtolower($name)]);
    }

    /**
     * Delete all clients.
     *
     * @return void
     */
    public static function flush()
    {
        self::$clients        = [];
        self::$globalRegionId = null;
    }

    /**
     * Get the global client.
     *
     * @return Client
     * @throws ClientException
     */
    public static function getGlobalClient()
    {
        return self::get(\ALIBABA_CLOUD_GLOBAL_CLIENT);
    }

    /**
     * Determine whether there is a client.
     *
     * @param string $clientName
     *
     * @return bool
     */
    public static function has($clientName)
    {
        return isset(self::$clients[\strtolower($clientName)]);
    }

    /**
     * A list of additional files to load.
     *
     * @return array
     * @throws ClientException when a file has a syntax error or does not exist or is not readable
     */
    public static function load()
    {
        if (\func_get_args() === []) {
            return (new IniCredential())->load();
        }
        $list = [];
        foreach (\func_get_args() as $filename) {
            $list[$filename] = (new IniCredential($filename))->load();
        }
        return $list;
    }

    /**
     * Custom Client.
     *
     * @param CredentialsInterface $credentials
     * @param SignatureInterface   $signature
     *
     * @return Client
     */
    public static function client(CredentialsInterface $credentials, SignatureInterface $signature)
    {
        return new Client($credentials, $signature);
    }

    /**
     * Use the AccessKey to complete the authentication.
     *
     * @param string $accessKeyId
     * @param string $accessKeySecret
     *
     * @return AccessKeyClient
     */
    public static function accessKeyClient($accessKeyId, $accessKeySecret)
    {
        return new AccessKeyClient($accessKeyId, $accessKeySecret);
    }

    /**
     * Use the AssumeRole of the RAM account to complete  the authentication.
     *
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $roleArn
     * @param string $roleSessionName
     *
     * @return RamRoleArnClient
     */
    public static function ramRoleArnClient($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName)
    {
        return new RamRoleArnClient($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName);
    }

    /**
     * Use the RAM role of an ECS instance to complete the authentication.
     *
     * @param string $roleName
     *
     * @return EcsRamRoleClient
     */
    public static function ecsRamRoleClient($roleName)
    {
        return new EcsRamRoleClient($roleName);
    }

    /**
     * Use the Bearer Token to complete the authentication.
     *
     * @param string $bearerToken
     *
     * @return BearerTokenClient
     */
    public static function bearerTokenClient($bearerToken)
    {
        return new BearerTokenClient($bearerToken);
    }

    /**
     * Use the STS Token to complete the authentication.
     *
     * @param string $accessKeyId     Access key ID
     * @param string $accessKeySecret Access Key Secret
     * @param string $securityToken   Security Token
     *
     * @return StsClient
     */
    public static function stsClient($accessKeyId, $accessKeySecret, $securityToken)
    {
        return new StsClient($accessKeyId, $accessKeySecret, $securityToken);
    }

    /**
     * Use the RSA key pair to complete the authentication (supported only on Japanese site)
     *
     * @param string $publicKeyId
     * @param string $privateKeyFile
     *
     * @return RsaKeyPairClient
     * @throws ClientException
     */
    public static function rsaKeyPairClient($publicKeyId, $privateKeyFile)
    {
        return new RsaKeyPairClient($publicKeyId, $privateKeyFile);
    }
}
