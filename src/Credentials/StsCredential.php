<?php

namespace AlibabaCloud\Client\Credentials;

/**
 * Use the STS Token to complete the authentication.
 *
 * @package   AlibabaCloud\Client\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/aliyun-openapi-php-sdk
 */
class StsCredential implements CredentialsInterface
{

    /**
     * @var string
     */
    private $accessKeyId;

    /**
     * @var string
     */
    private $accessKeySecret;

    /**
     * @var string
     */
    private $securityToken;

    /**
     * StsCredential constructor.
     *
     * @param string $accessKeyId     Access key ID
     * @param string $accessKeySecret Access Key Secret
     * @param string $securityToken   Security Token
     */
    public function __construct($accessKeyId, $accessKeySecret, $securityToken)
    {
        $this->accessKeyId     = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->securityToken   = $securityToken;
    }

    /**
     * @return string
     */
    public function getAccessKeyId()
    {
        return $this->accessKeyId;
    }

    /**
     * @return string
     */
    public function getAccessKeySecret()
    {
        return $this->accessKeySecret;
    }

    /**
     * @return string
     */
    public function getSecurityToken()
    {
        return $this->securityToken;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->accessKeyId#$this->accessKeySecret#$this->securityToken";
    }
}
