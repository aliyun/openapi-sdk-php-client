<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\Clients\Client;

/**
 * Class Provider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class Provider
{
    /**
     * @var array
     */
    protected static $credentialsCache = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * CredentialTrait constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the toString of the credentials as the key.
     *
     * @return string
     */
    protected function key()
    {
        return (string)$this->client->getCredential();
    }

    /**
     * Cache credentials.
     *
     * @param array $result
     */
    protected function cache(array $result)
    {
        self::$credentialsCache[$this->key()] = $result;
    }

    /**
     * Get the credentials from the cache in the validity period.
     *
     * @return array|null
     */
    public function getCredentialsInCache()
    {
        if (isset(self::$credentialsCache[$this->key()])) {
            $result = self::$credentialsCache[$this->key()];
            if (\strtotime($result['Expiration']) - \time() >= ECS_ROLE_EXPIRE_TIME) {
                return $result;
            }
        }
        unset(self::$credentialsCache[$this->key()]);
        return null;
    }
}
