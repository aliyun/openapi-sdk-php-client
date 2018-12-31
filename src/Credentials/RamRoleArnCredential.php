<?php

namespace AlibabaCloud\Client\Credentials;

/**
 * Use the AssumeRole of the RAM account to complete  the authentication.
 *
 * @package   AlibabaCloud\Client\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class RamRoleArnCredential implements CredentialsInterface
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
    private $roleArn;
    /**
     * @var string
     */
    private $roleSessionName;

    /**
     * Class constructor.
     *
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $roleArn
     * @param string $roleSessionName
     */
    public function __construct($accessKeyId, $accessKeySecret, $roleArn, $roleSessionName)
    {
        $this->accessKeyId     = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->roleArn         = $roleArn;
        $this->roleSessionName = $roleSessionName;
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
    public function getRoleArn()
    {
        return $this->roleArn;
    }

    /**
     * @return string
     */
    public function getRoleSessionName()
    {
        return $this->roleSessionName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->accessKeyId#$this->accessKeySecret#$this->roleArn#$this->roleSessionName";
    }
}
