<?php

namespace AlibabaCloud\Client\Tests\Unit\Exception;

use AlibabaCloud\Client\Exception\ClientException;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientExceptionTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Exception
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
