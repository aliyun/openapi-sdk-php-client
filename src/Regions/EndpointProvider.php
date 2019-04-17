<?php

namespace AlibabaCloud\Client\Regions;

use RuntimeException;

/**
 * Class EndpointProvider
 *
 * @package    AlibabaCloud\Client\Regions
 *
 * @deprecated
 * @codeCoverageIgnore
 */
class EndpointProvider
{
    /**
     * @deprecated
     */
    public static function findProductDomain()
    {
        throw new RuntimeException('deprecated since 2.0, Use AlibabaCloud::resolveHost() instead.');
    }

    /**
     * @deprecated
     */
    public static function addEndpoint()
    {
        throw new RuntimeException('deprecated since 2.0, Use AlibabaCloud::addHost() instead.');
    }
}
