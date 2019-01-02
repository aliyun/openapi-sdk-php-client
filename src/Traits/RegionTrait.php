<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\AlibabaCloud;

/**
 * Trait RegionTrait
 *
 * @package   AlibabaCloud\Client\Traits
 *
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
