<?php

namespace AlibabaCloud\Client\Exception;

/**
 * Class AlibabaCloudException
 *
 * @package   AlibabaCloud\Client\Exception
 */
abstract class AlibabaCloudException extends \Exception
{

    /**
     * @var string
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     *
     * @param $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     *
     * @param $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return             void
     */
    public function setErrorType()
    {
    }
}
