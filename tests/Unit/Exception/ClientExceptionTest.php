<?php

namespace AlibabaCloud\Client\Tests\Unit\Exception;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class ClientExceptionTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Exception
 *
 * @coversDefaultClass \AlibabaCloud\Client\Exception\ClientException
 */
class ClientExceptionTest extends TestCase
{

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {

        // Setup
        $errorMessage = 'message';
        $errorCode    = 'code';

        // Test
        $exception = new ClientException($errorMessage, $errorCode);

        // Assert
        static::assertEquals($errorMessage, $exception->getErrorMessage());
        static::assertEquals($errorCode, $exception->getErrorCode());
    }
}
