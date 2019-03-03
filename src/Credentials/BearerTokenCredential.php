<?php

namespace AlibabaCloud\Client\Credentials;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Filter;

/**
 * Class BearerTokenCredential
 *
 * @package   AlibabaCloud\Client\Credentials
 */
class BearerTokenCredential implements CredentialsInterface
{

    /**
     * @var string
     */
    private $bearerToken;

    /**
     * Class constructor.
     *
     * @param string $bearerToken
     *
     * @throws ClientException
     */
    public function __construct($bearerToken)
    {
        Filter::bearerToken($bearerToken);

        $this->bearerToken = $bearerToken;
    }

    /**
     * @return string
     */
    public function getBearerToken()
    {
        return $this->bearerToken;
    }

    /**
     * @return string
     */
    public function getAccessKeyId()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getAccessKeySecret()
    {
        return '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "bearerToken#$this->bearerToken";
    }
}
