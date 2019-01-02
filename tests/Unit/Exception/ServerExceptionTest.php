<?php

namespace AlibabaCloud\Client\Tests\Unit\Exception;

use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

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
        $errorMessage = 'message';
        $errorCode    = 'code';
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
        $this->assertEquals($errorMessage, $exception->getErrorMessage());
        $this->assertEquals($errorCode, $exception->getErrorCode());
        $this->assertEquals('RequestId', $exception->getRequestId());
        $this->assertInstanceOf(Result::class, $exception->getResult());
        $this->assertEquals('message', $exception->getResult()->toArray()['message']);
        $this->assertEquals('code', $exception->getResult()->toArray()['code']);
        $this->assertEquals('Message', $exception->getResult()->toArray()['Message']);
        $this->assertEquals('Code', $exception->getResult()->toArray()['Code']);
        $this->assertEquals('errorMsg', $exception->getResult()->toArray()['errorMsg']);
        $this->assertEquals('errorCode', $exception->getResult()->toArray()['errorCode']);
        $this->assertEquals('requestId', $exception->getResult()->toArray()['requestId']);
        $this->assertEquals('RequestId', $exception->getResult()->toArray()['RequestId']);
    }

    public function testNoContentAndParameter()
    {
        // Setup
        $body   = \json_encode(
            [
                '1' => '1',
            ]
        );
        $result = new Result(new Response(200, [], $body));

        // Test
        $exception = new ServerException($result);

        // Assert
        $this->assertEquals('{"1":"1"}', $exception->getErrorMessage());
    }
}
