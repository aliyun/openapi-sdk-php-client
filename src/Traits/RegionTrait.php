<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;

/**
 * Trait RegionTrait
 *
 * @package   AlibabaCloud\Client\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @mixin     AlibabaCloud
 */
trait RegionTrait
{
    /**
     * @var string|null Global default RegionId
     */
    protected static $globalRegionId;

    /**
     * Set the Global default RegionId.
     *
     * @param string $globalRegionId
     */
    public static function setGlobalRegionId($globalRegionId)
    {
        self::$globalRegionId = $globalRegionId;
    }

    /**
     * Get the Global default RegionId.
     *
     * @return string|null
     */
    public static function getGlobalRegionId()
    {
        return self::$globalRegionId;
    }
}
