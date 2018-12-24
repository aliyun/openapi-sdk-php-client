<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit\Exception;

use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ServerExceptionTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Exception
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
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
        $body         = \json_encode([
                                         'message'   => 'message',
                                         'code'      => 'code',
                                         'Message'   => 'Message',
                                         'Code'      => 'Code',
                                         'errorMsg'  => 'errorMsg',
                                         'errorCode' => 'errorCode',
                                         'requestId' => 'requestId',
                                         'RequestId' => 'RequestId',
                                     ]);
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
        $body   = \json_encode([
                                   '1' => '1',
                               ]);
        $result = new Result(new Response(200, [], $body));

        // Test
        $exception = new ServerException($result);

        // Assert
        $this->assertEquals('{"1":"1"}', $exception->getErrorMessage());
    }
}
