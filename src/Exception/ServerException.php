<?php

namespace AlibabaCloud\Client\Exception;

use AlibabaCloud\Client\Result\Result;

/**
 * Class ServerException
 *
 * @package   AlibabaCloud\Client\Exception
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class ServerException extends AlibabaCloudException
{

    /**
     * @var string
     */
    protected $requestId;
    /**
     * @var Result
     */
    protected $result;

    /**
     * ServerException constructor.
     *
     * @param Result|null $result
     * @param string      $errorMessage
     * @param string      $errorCode
     */
    public function __construct(Result $result, $errorMessage = '', $errorCode = '')
    {
        $this->result = $result;
        $this->settingProperties();
        if ($errorMessage !== '') {
            $this->errorMessage = $errorMessage;
        }
        if ($errorCode !== '') {
            $this->errorCode = $errorCode;
        }
        if (!$this->errorMessage) {
            $this->errorMessage = (string)$this->result->getResponse()->getBody();
        }
        $message = $this->errorCode
                   . ': '
                   . $this->errorMessage
                   . ' HTTP Status: '
                   . $this->result->getResponse()->getStatusCode()
                   . ' RequestID: '
                   . $this->requestId;
        parent::__construct($message, $this->result->getResponse()->getStatusCode());
    }

    /**
     * @return void
     */
    private function settingProperties()
    {
        if (isset($this->result['message'])) {
            $this->errorMessage = $this->result['message'];
            $this->errorCode    = $this->result['code'];
        }
        if (isset($this->result['Message'])) {
            $this->errorMessage = $this->result['Message'];
            $this->errorCode    = $this->result['Code'];
        }
        if (isset($this->result['errorMsg'])) {
            $this->errorMessage = $this->result['errorMsg'];
            $this->errorCode    = $this->result['errorCode'];
        }
        if (isset($this->result['requestId'])) {
            $this->requestId = $this->result['requestId'];
        }
        if (isset($this->result['RequestId'])) {
            $this->requestId = $this->result['RequestId'];
        }
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return             string
     */
    public function getErrorType()
    {
        return 'Server';
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return             int
     */
    public function getHttpStatus()
    {
        return $this->getResult()->getResponse()->getStatusCode();
    }
}
