<?php

namespace AlibabaCloud\Client;

/**
 * Class Format
 *
 * @package AlibabaCloud\Client
 */
class Format
{
    /**
     * @var string
     */
    private $format;

    /**
     * Format constructor.
     *
     * @param string $format
     */
    private function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * @param $format
     *
     * @return Format
     */
    public static function create($format)
    {
        return new static($format);
    }

    /**
     * @return mixed|string
     */
    public function toString()
    {
        $key = \strtoupper($this->format);

        $list = [
            'JSON' => 'application/json',
            'XML'  => 'application/xml'
        ];

        return isset($list[$key]) ? $list[$key] : 'application/octet-stream';
    }
}
