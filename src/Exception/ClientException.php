<?php

namespace AlibabaCloud\Client\Exception;

use Exception;

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
     * @param string         $errorMessage
     * @param string         $errorCode
     * @param Exception|null $previous
     */
    public function __construct($errorMessage, $errorCode, $previous = null)
    {
        parent::__construct($errorMessage, 0, $previous);
        $this->errorMessage = $errorMessage;
        $this->errorCode    = $errorCode;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return string
     * @deprecated deprecated since version 2.0.
     */
    public function getErrorType()
    {
        return 'Client';
    }
}
