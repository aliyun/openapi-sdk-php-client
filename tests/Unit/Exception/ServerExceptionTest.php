<?php

namespace AlibabaCloud\Client\Tests\Unit\Exception;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Client\Exception\ServerException;

/**
 * Class ServerExceptionTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Exception
 *
 * @coversDefaultClass \AlibabaCloud\Client\Exception\ServerException
 */
class ServerExceptionTest extends TestCase
{
    public function testConstruct()
    {

        // Setup
        $errorMessage = 'errorMsg';
        $errorCode    = 'errorCode';
        $body         = \json_encode(
            [
                'message'   => 'message',
                'code'      => 'code',
                'Message'   => 'Message',
                'Code'      => 'Code',
                'errorMsg'  => 'errorMsg',
                'errorCode' => 'errorCode',
                'requestId' => 'requestId',
                'RequestId' => 'RequestId',
            ]
        );
        $result       = new Result(new Response(200, [], $body));

        // Test
        $exception = new ServerException($result, $errorMessage, $errorCode);

        // Assert
        static::assertEquals($errorMessage, $exception->getErrorMessage());
        static::assertEquals($errorCode, $exception->getErrorCode());
        static::assertEquals('RequestId', $exception->getRequestId());
        static::assertInstanceOf(Result::class, $exception->getResult());
        static::assertEquals('message', $exception->getResult()->toArray()['message']);
        static::assertEquals('code', $exception->getResult()->toArray()['code']);
        static::assertEquals('Message', $exception->getResult()->toArray()['Message']);
        static::assertEquals('Code', $exception->getResult()->toArray()['Code']);
        static::assertEquals('errorMsg', $exception->getResult()->toArray()['errorMsg']);
        static::assertEquals('errorCode', $exception->getResult()->toArray()['errorCode']);
        static::assertEquals('requestId', $exception->getResult()->toArray()['requestId']);
        static::assertEquals('RequestId', $exception->getResult()->toArray()['RequestId']);
    }

    public function testNoContentAndParameter()
    {
        // Setup
        $body   = \json_encode(
            [
                '1' => '1'
            ]
        );
        $result = new Result(new Response(200, [], $body));

        // Test
        $exception = new ServerException($result);

        // Assert
        static::assertEquals('{"1":"1"}', $exception->getErrorMessage());
    }
}
