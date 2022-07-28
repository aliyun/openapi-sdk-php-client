<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Traits;

use AlibabaCloud\Client\Traits\HasDataTrait;

/**
 * Class HasDataTraitClass
 *
 * @package AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Traits
 */
class HasDataTraitClass implements \ArrayAccess, \IteratorAggregate, \Countable
{
    use HasDataTrait;

    /**
     * HasDataTraitClass constructor.
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->dot($data);
    }
}
