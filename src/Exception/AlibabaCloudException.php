<?php

namespace AlibabaCloud\Client\Exception;

use RuntimeException;

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
     * @deprecated
     */
    public function setErrorCode()
    {
        throw new RuntimeException('deprecated since 2.0.');
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
     * @deprecated
     */
    public function setErrorMessage()
    {
        throw new RuntimeException('deprecated since 2.0.');
    }

    /**
     * @codeCoverageIgnore
     * @deprecated
     */
    public function setErrorType()
    {
        throw new RuntimeException('deprecated since 2.0.');
    }
}
