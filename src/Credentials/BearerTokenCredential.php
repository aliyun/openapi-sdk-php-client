<?php

namespace AlibabaCloud\Client\Credentials;

/**
 * Class BearerTokenCredential
 *
 * @package   AlibabaCloud\Client\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
     */
    public function __construct($bearerToken)
    {
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
