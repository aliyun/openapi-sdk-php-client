<?php

namespace AlibabaCloud\Client\Traits;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Filter\ClientFilter;

/**
 * Trait RegionTrait
 *
 * @package AlibabaCloud\Client\Traits
 */
trait RegionTrait
{

    /**
     * @var string|null
     */
    public $regionId;

    /**
     * @param string $regionId
     *
     * @return $this
     * @throws ClientException
     */
    public function regionId($regionId)
    {
        ClientFilter::regionId($regionId);

        $this->regionId = $regionId;

        return $this;
    }
}
