<?php

namespace AlibabaCloud\Client\Filter;

use AlibabaCloud\Client\SDK;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class ClientFilter
 *
 * @package AlibabaCloud\Client\Filter
 */
class ClientFilter
{
    /**
     * @param $regionId
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function regionId($regionId)
    {
        if (!is_string($regionId)) {
            throw new ClientException(
                'Region ID must be a string',
                SDK::INVALID_ARGUMENT
            );
        }

        if ($regionId === '') {
            throw new ClientException(
                'Region ID cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return $regionId;
    }

    /**
     * @param $clientName
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function clientName($clientName)
    {
        if (!is_string($clientName)) {
            throw new ClientException(
                'Client Name must be a string',
                SDK::INVALID_ARGUMENT
            );
        }

        if ($clientName === '') {
            throw new ClientException(
                'Client Name cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return strtolower($clientName);
    }

    /**
     * @param $connectTimeout
     *
     * @return mixed
     * @throws ClientException
     */
    public static function connectTimeout($connectTimeout)
    {
        if ($connectTimeout === '') {
            throw new ClientException(
                'Connect Timeout cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return $connectTimeout;
    }

    /**
     * @param $timeout
     *
     * @return mixed
     * @throws ClientException
     */
    public static function timeout($timeout)
    {
        if ($timeout === '') {
            throw new ClientException(
                'Timeout cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return $timeout;
    }
}
