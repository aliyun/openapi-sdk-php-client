<?php

namespace AlibabaCloud\Client\Profile;

use RuntimeException;

/**
 * Class DefaultProfile
 *
 * @package    AlibabaCloud\Client\Profile
 *
 * @deprecated
 * @codeCoverageIgnore
 */
class DefaultProfile
{
    public static function getProfile()
    {
        throw new RuntimeException('deprecated since 2.0, Use AlibabaCloud::accessKeyClient() instead.');
    }

    public static function getRamRoleArnProfile()
    {
        throw new RuntimeException('deprecated since 2.0, Use AlibabaCloud::ramRoleArnClient() instead.');
    }

    public static function getEcsRamRoleProfile()
    {
        throw new RuntimeException('deprecated since 2.0, Use AlibabaCloud::ecsRamRoleClient() instead.');
    }

    public static function getBearerTokenProfile()
    {
        throw new RuntimeException('deprecated since 2.0, Use AlibabaCloud::bearerTokenClient() instead.');
    }
}
