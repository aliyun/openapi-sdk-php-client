<?php

namespace AlibabaCloud\Client\Traits;

use Exception;

/**
 * Trait FormatTrait
 *
 * @package   AlibabaCloud\Client\Traits
 */
trait FormatTrait
{
    /**
     * @param string $string
     *
     * @return array
     */
    private function xmlToArray($string)
    {
        try {
            return json_decode(json_encode(simplexml_load_string($string)), true);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private function jsonToArray($response)
    {
        try {
            return \GuzzleHttp\json_decode($response, true);
        } catch (\InvalidArgumentException $e) {
            return [];
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param int $options
     *
     * @return false|string
     */
    public function toJson($options = 0)
    {
        return \json_encode($this->data, $options);
    }
}
