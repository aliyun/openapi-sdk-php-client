<?php

namespace AlibabaCloud\Client\Traits;

use RuntimeException;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Filter\ClientFilter;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Trait DefaultRegionTrait
 *
 * @package   AlibabaCloud\Client\Traits
 *
 * @mixin     AlibabaCloud
 */
trait DefaultRegionTrait
{
    /**
     * @var string|null Default RegionId
     */
    protected static $defaultRegionId;

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public static function setGlobalRegionId()
    {
        throw new RuntimeException('deprecated since 2.0, Use setDefaultRegionId() instead.');
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public static function getGlobalRegionId()
    {
        throw new RuntimeException('deprecated since 2.0, Use getGlobalRegionId() instead.');
    }

    /**
     * Get the default RegionId.
     *
     * @return string|null
     */
    public static function getDefaultRegionId()
    {
        return self::$defaultRegionId;
    }

    /**
     * Set the default RegionId.
     *
     * @param string $regionId
     *
     * @throws ClientException
     */
    public static function setDefaultRegionId($regionId)
    {
        ClientFilter::regionId($regionId);

        self::$defaultRegionId = $regionId;
    }
}
