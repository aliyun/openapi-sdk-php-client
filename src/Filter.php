<?php

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class Filter
 *
 * @package AlibabaCloud\Client
 */
class Filter
{
    /**
     * @param string $clientName
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($clientName === '') {
            throw new ClientException(
                'Client Name cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return strtolower($clientName);
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function name($name)
    {
        if (!is_string($name)) {
            throw new ClientException(
                'Name must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($name === '') {
            throw new ClientException(
                'Name cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $name;
    }

    /**
     * @param string $value
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function value($value)
    {
        if (!is_numeric($value) && !is_string($value)) {
            throw new ClientException(
                'Value must be a string or int',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($value === '') {
            throw new ClientException(
                'Value cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $value;
    }

    /**
     * @param $accessKeyId
     * @param $accessKeySecret
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function AccessKey($accessKeyId, $accessKeySecret)
    {
        if (is_numeric($accessKeyId)) {
            $accessKeyId = (string)$accessKeyId;
        }

        if (is_numeric($accessKeySecret)) {
            $accessKeySecret = (string)$accessKeySecret;
        }

        if (!is_string($accessKeyId)) {
            throw new ClientException(
                'AccessKey ID must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($accessKeyId === '') {
            throw new ClientException(
                'AccessKey ID cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if (!is_string($accessKeySecret)) {
            throw new ClientException(
                'AccessKey Secret must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($accessKeySecret === '') {
            throw new ClientException(
                'AccessKey Secret cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }
    }

    /**
     * @param string $host
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($host === '') {
            throw new ClientException(
                'Host cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $host;
    }

    /**
     * @param string $product
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function product($product)
    {
        if (!is_string($product)) {
            throw new ClientException(
                'Product must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($product === '') {
            throw new ClientException(
                'Product cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $product;
    }

    /**
     * @param string $regionId
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($regionId === '') {
            throw new ClientException(
                'Region ID cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $regionId;
    }

    /**
     * @param string $pattern
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function pattern($pattern)
    {
        if (!is_string($pattern)) {
            throw new ClientException(
                'Pattern must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($pattern === '') {
            throw new ClientException(
                'Pattern cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $pattern;
    }

    /**
     * @param string $roleName
     *
     * @return string
     *
     * @throws ClientException
     */
    public static function roleName($roleName)
    {
        if (!is_string($roleName)) {
            throw new ClientException(
                'Role Name must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($roleName === '') {
            throw new ClientException(
                'Role Name cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $roleName;
    }

    /**
     * @param string $scheme
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($scheme === '') {
            throw new ClientException(
                'Scheme cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $scheme;
    }

    /**
     * @param $format
     *
     * @return mixed
     * @throws ClientException
     */
    public static function format($format)
    {
        if (!is_string($format)) {
            throw new ClientException(
                'Format must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($format === '') {
            throw new ClientException(
                'Format cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $format;
    }

    /**
     * @param $action
     *
     * @return mixed
     * @throws ClientException
     */
    public static function action($action)
    {
        if (!is_string($action)) {
            throw new ClientException(
                'Action must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($action === '') {
            throw new ClientException(
                'Action cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $action;
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($body === '') {
            throw new ClientException(
                'Body cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $body;
    }

    /**
     * @param $endpointType
     *
     * @return mixed
     * @throws ClientException
     */
    public static function endpointType($endpointType)
    {
        if (!is_string($endpointType)) {
            throw new ClientException(
                'Endpoint Type must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($endpointType === '') {
            throw new ClientException(
                'Endpoint Type cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $endpointType;
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($method === '') {
            throw new ClientException(
                'Method cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return \strtoupper($method);
    }

    /**
     * @param $bearerToken
     *
     * @return mixed
     * @throws ClientException
     */
    public static function bearerToken($bearerToken)
    {
        if (!is_string($bearerToken)) {
            throw new ClientException(
                'Bearer Token must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($bearerToken === '') {
            throw new ClientException(
                'Bearer Token cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $bearerToken;
    }

    /**
     * @param $publicKeyId
     *
     * @return mixed
     * @throws ClientException
     */
    public static function publicKeyId($publicKeyId)
    {
        if (!is_string($publicKeyId)) {
            throw new ClientException(
                'Public Key ID must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($publicKeyId === '') {
            throw new ClientException(
                'Public Key ID cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $publicKeyId;
    }

    /**
     * @param $privateKeyFile
     *
     * @return mixed
     * @throws ClientException
     */
    public static function privateKeyFile($privateKeyFile)
    {
        if (!is_string($privateKeyFile)) {
            throw new ClientException(
                'Private Key File must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($privateKeyFile === '') {
            throw new ClientException(
                'Private Key File cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $privateKeyFile;
    }

    /**
     * @param $version
     *
     * @return mixed
     * @throws ClientException
     */
    public static function version($version)
    {
        if (!is_string($version)) {
            throw new ClientException(
                'Version must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($version === '') {
            throw new ClientException(
                'Version cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $version;
    }

    /**
     * @param $serviceCode
     *
     * @return mixed
     * @throws ClientException
     */
    public static function serviceCode($serviceCode)
    {
        if (!is_string($serviceCode)) {
            throw new ClientException(
                'Service Code must be a string',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        if ($serviceCode === '') {
            throw new ClientException(
                'Service Code cannot be empty',
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $serviceCode;
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
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
                \ALIBABA_CLOUD_INVALID_ARGUMENT
            );
        }

        return $timeout;
    }
}
