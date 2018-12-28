<?php

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Clients\AccessKeyClient;
use AlibabaCloud\Client\Clients\BearerTokenClient;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Clients\EcsRamRoleClient;
use AlibabaCloud\Client\Clients\RamRoleArnClient;
use AlibabaCloud\Client\Clients\RsaKeyPairClient;
use AlibabaCloud\Client\Clients\StsClient;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Signature\SignatureInterface;

/**
 * Trait ClientCreateTrait
 *
 * @package   \AlibabaCloud\Client
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/aliyun-openapi-php-sdk
 * @mixin AlibabaCloud
 */
trait ClientCreateTrait
{
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
