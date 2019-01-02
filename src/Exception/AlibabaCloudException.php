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
     * @codeCoverageIgnore
     *
     * @deprecated deprecated since version 2.0.
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
     * @codeCoverageIgnore
     *
     * @deprecated deprecated since version 2.0.
     *
     * @param $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @codeCoverageIgnore
     *
     * @deprecated deprecated since version 2.0.
     *
     * @return             void
     */
    public function setErrorType()
    {
    }
}
