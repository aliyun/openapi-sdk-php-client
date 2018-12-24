<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Exception;

use AlibabaCloud\Client\Result\Result;

/**
 * Class ServerException
 *
 * @package AlibabaCloud\Client\Exception
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
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

        if (isset($result['message'])) {
            $this->errorMessage = $result['message'];
            $this->errorCode    = $result['code'];
        }
        if (isset($result['Message'])) {
            $this->errorMessage = $result['Message'];
            $this->errorCode    = $result['Code'];
        }
        if (isset($result['errorMsg'])) {
            $this->errorMessage = $result['errorMsg'];
            $this->errorCode    = $result['errorCode'];
        }
        if ($errorMessage !== '') {
            $this->errorMessage = $errorMessage;
        }
        if ($errorCode !== '') {
            $this->errorCode = $errorCode;
        }
        if (isset($result['requestId'])) {
            $this->requestId = $result['requestId'];
        }
        if (isset($result['RequestId'])) {
            $this->requestId = $result['RequestId'];
        }
        if (!$this->errorMessage) {
            $this->errorMessage = $result->getResponse()->getBody()->getContents();
        }
        $message = $this->errorCode
                   . ': '
                   . $this->errorMessage
                   . ' HTTP Status: '
                   . $result->getResponse()->getStatusCode()
                   . ' RequestID: '
                   . $this->requestId;
        parent::__construct($message, $result->getResponse()->getStatusCode());
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return string
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
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->getResult()->getResponse()->getStatusCode();
    }
}
