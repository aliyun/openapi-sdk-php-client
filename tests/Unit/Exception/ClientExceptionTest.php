<?php

namespace AlibabaCloud\Client\Tests\Unit\Exception;

use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

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
        $this->assertEquals($errorMessage, $exception->getErrorMessage());
        $this->assertEquals($errorCode, $exception->getErrorCode());
    }
}
