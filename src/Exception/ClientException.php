<?php

namespace AlibabaCloud\Client\Exception;

/**
 * Class ClientException
 *
 * @package   AlibabaCloud\Client\Exception
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class ClientException extends AlibabaCloudException
{

    /**
     * ClientException constructor.
     *
     * @param string          $errorMessage
     * @param string          $errorCode
     * @param \Throwable|null $previous
     */
    public function __construct($errorMessage, $errorCode, $previous = null)
    {
        parent::__construct($errorMessage, 0, $previous);
        $this->errorMessage = $errorMessage;
        $this->errorCode    = $errorCode;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return             string
     */
    public function getErrorType()
    {
        return 'Client';
    }
}
