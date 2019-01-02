<?php

namespace AlibabaCloud\Client\Exception;

/**
 * Class ClientException
 *
 * @package   AlibabaCloud\Client\Exception
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
     *
     * @return string
     */
    public function getErrorType()
    {
        return 'Client';
    }
}
