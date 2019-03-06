<?php

namespace AlibabaCloud\Client\Filter;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\SDK;

/**
 * Class HttpFilter
 *
 * @package AlibabaCloud\Client\Filter
 */
class HttpFilter
{
    /**
     * @param $host
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function host($host)
    {
        if (!is_string($host)) {
            throw new ClientException(
                'Host must be a string',
                SDK::INVALID_ARGUMENT
            );
        }

        if ($host === '') {
            throw new ClientException(
                'Host cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return $host;
    }

    /**
     * @param $scheme
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function scheme($scheme)
    {
        if (!is_string($scheme)) {
            throw new ClientException(
                'Scheme must be a string',
                SDK::INVALID_ARGUMENT
            );
        }

        if ($scheme === '') {
            throw new ClientException(
                'Scheme cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return $scheme;
    }

    /**
     * @param $body
     *
     * @return mixed
     * @throws ClientException
     */
    public static function body($body)
    {
        if (!is_string($body) && !is_numeric($body)) {
            throw new ClientException(
                'Body must be a string or int',
                SDK::INVALID_ARGUMENT
            );
        }

        if ($body === '') {
            throw new ClientException(
                'Body cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return $body;
    }

    /**
     * @param $method
     *
     * @return mixed
     * @throws ClientException
     */
    public static function method($method)
    {
        if (!is_string($method)) {
            throw new ClientException(
                'Method must be a string',
                SDK::INVALID_ARGUMENT
            );
        }

        if ($method === '') {
            throw new ClientException(
                'Method cannot be empty',
                SDK::INVALID_ARGUMENT
            );
        }

        return \strtoupper($method);
    }
}
