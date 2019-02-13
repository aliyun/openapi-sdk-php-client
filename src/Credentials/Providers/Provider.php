<?php

namespace AlibabaCloud\Client\Credentials\Providers;

use AlibabaCloud\Client\Clients\Client;

/**
 * Class Provider
 *
 * @package   AlibabaCloud\Client\Credentials\Providers
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
     * @param array $credential
     */
    protected function cache(array $credential)
    {
        self::$credentialsCache[$this->key()] = $credential;
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
            if (\strtotime($result['Expiration']) - \time() >= \ALIBABA_CLOUD_EXPIRATION_INTERVAL) {
                return $result;
            }
        }
        unset(self::$credentialsCache[$this->key()]);

        return null;
    }
}
