<?php

namespace AlibabaCloud\Client\Profile;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;

/**
 * Class DefaultProfile
 *
 * @package    AlibabaCloud\Client\Profile
 *
 * @author     Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright  Alibaba Group
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link       https://github.com/aliyun/openapi-sdk-php-client
 * @deprecated
 */
class DefaultProfile
{

    /**
     * @param string $regionId
     * @param string $accessKeyId
     * @param string $accessKeySecret
     *
     * @return Client
     */
    public static function getProfile($regionId, $accessKeyId, $accessKeySecret)
    {
        return AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                           ->regionId($regionId);
    }

    /**
     * @param string $regionId
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $roleArn
     * @param string $roleSessionName
     *
     * @return Client
     */
    public static function getRamRoleArnProfile($regionId, $accessKeyId, $accessKeySecret, $roleArn, $roleSessionName)
    {
        return AlibabaCloud::ramRoleArnClient($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName)
                           ->regionId($regionId);
    }

    /**
     * @param string $regionId
     * @param string $roleName
     *
     * @return Client
     */
    public static function getEcsRamRoleProfile($regionId, $roleName)
    {
        return AlibabaCloud::ecsRamRoleClient($roleName)
                           ->regionId($regionId);
    }

    /**
     * @param string $regionId
     * @param string $bearerToken
     *
     * @return Client
     */
    public static function getBearerTokenProfile($regionId, $bearerToken)
    {
        return AlibabaCloud::bearerTokenClient($bearerToken)
                           ->regionId($regionId);
    }
}
