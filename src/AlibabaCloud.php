<?php

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Credentials\Ini\IniCredential;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class AlibabaCloud
 *
 * @package   AlibabaCloud\Client
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class AlibabaCloud
{
    use ClientCreateTrait;

    /**
     * @var array Containers of Clients
     */
    private static $clients = [];

    /**
     * @var string|null Global default RegionId
     */
    protected static $globalRegionId;

    /**
     * A list of additional files to load.
     *
     * @return array
     * @throws ClientException when a file has a syntax error or does not exist or is not readable
     */
    public static function load()
    {
        if (\func_get_args() === []) {
            return (new IniCredential())->load();
        }
        $list = [];
        foreach (\func_get_args() as $filename) {
            $list[$filename] = (new IniCredential($filename))->load();
        }
        return $list;
    }

    /**
     * Get the Client instance by name.
     *
     * @param string $clientName
     *
     * @return Client
     * @throws ClientException
     */
    public static function get($clientName)
    {
        if (self::has($clientName)) {
            return self::$clients[\strtolower($clientName)];
        }
        throw new ClientException(
            ALIBABA_CLOUD
            . ' Client Not Found: '
            . $clientName,
            \ALI_CLIENT_NOT_FOUND
        );
    }

    /**
     * @param string $clientName
     * @param Client $client
     *
     * @return Client
     */
    public static function set($clientName, Client $client)
    {
        return self::$clients[\strtolower($clientName)] = $client;
    }

    /**
     * Get all clients.
     *
     * @return array
     */
    public static function all()
    {
        return self::$clients;
    }

    /**
     * Delete the client by specifying name.
     *
     * @param string $name
     */
    public static function del($name)
    {
        unset(self::$clients[\strtolower($name)]);
    }

    /**
     * Delete all clients.
     *
     * @return void
     */
    public static function flush()
    {
        self::$clients        = [];
        self::$globalRegionId = null;
    }

    /**
     * Get the global client.
     *
     * @return Client
     * @throws ClientException
     */
    public static function getGlobalClient()
    {
        return self::get(\ALIBABA_CLOUD_GLOBAL_CLIENT);
    }

    /**
     * Determine whether there is a client.
     *
     * @param string $clientName
     *
     * @return bool
     */
    public static function has($clientName)
    {
        return isset(self::$clients[\strtolower($clientName)]);
    }

    /**
     * Set the Global default RegionId.
     *
     * @param string $globalRegionId
     */
    public static function setGlobalRegionId($globalRegionId)
    {
        self::$globalRegionId = $globalRegionId;
    }

    /**
     * Get the Global default RegionId.
     *
     * @return string|null
     */
    public static function getGlobalRegionId()
    {
        return self::$globalRegionId;
    }
}
