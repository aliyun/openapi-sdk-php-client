<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\CS;

use AlibabaCloud\Client\Request\RoaRequest;

class DescribeClustersForRegionRequest extends RoaRequest
{
    public $pathPattern = '/regions/[region_id]/clusters';

    public $product = 'CS';

    public $version = '2015-12-15';

    public $action = 'DescribeClustersForRegion';

    protected $scheme = 'https';
}
