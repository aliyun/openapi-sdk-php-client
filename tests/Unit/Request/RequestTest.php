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

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Rds\DeleteDatabaseRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\Request
 */
class RequestTest extends TestCase
{
    public function testConstruct()
    {
        // Setup
        $options = ['testConstruct' => __METHOD__];

        // Test
        $rpcRequest = new RpcRequest($options);
        $roaRequest = new RoaRequest($options);

        // Assert
        self::assertEquals(__METHOD__, $rpcRequest->options['testConstruct']);
        self::assertEquals(__METHOD__, $roaRequest->options['testConstruct']);
    }

    public function testFormat()
    {
        // Setup
        $format     = 'rss';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->format($format);
        $roaRequest->format($format);

        // Assert
        self::assertEquals(\strtoupper($format), $rpcRequest->format);
        self::assertEquals(\strtoupper($format), $roaRequest->format);
    }

    public function testBody()
    {
        // Setup
        $body       = 'rss';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->body($body);
        $roaRequest->body($body);

        // Assert
        self::assertEquals($body, $rpcRequest->options['body']);
        self::assertEquals($body, $roaRequest->options['body']);
    }

    public function testScheme()
    {
        // Setup
        $scheme     = 'no';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->scheme($scheme);
        $roaRequest->scheme($scheme);

        // Assert
        self::assertEquals($scheme, $rpcRequest->uriComponents->getScheme());
        self::assertEquals($scheme, $roaRequest->uriComponents->getScheme());
    }

    public function testHost()
    {
        // Setup
        $host       = 'domain';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->host($host);
        $roaRequest->host($host);

        // Assert
        self::assertEquals($host, $rpcRequest->uriComponents->getHost());
        self::assertEquals($host, $roaRequest->uriComponents->getHost());
    }

    public function testMethod()
    {
        // Setup
        $method     = 'method';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->method($method);
        $roaRequest->method($method);

        // Assert
        self::assertEquals(\strtoupper($method), $rpcRequest->method);
        self::assertEquals(\strtoupper($method), $roaRequest->method);
    }

    public function testClient()
    {
        // Setup
        $clientName = 'clientName';
        $rpcRequest = new RpcRequest();
        $roaRequest = new RoaRequest();

        // Test
        $rpcRequest->client($clientName);
        $roaRequest->client($clientName);

        // Assert
        self::assertEquals($clientName, $rpcRequest->clientName);
        self::assertEquals($clientName, $roaRequest->clientName);
    }

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testIsDebug()
    {
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->name('temp');
        $request = (new DeleteDatabaseRequest())->client('temp')
                                                ->debug(false);
        self::assertFalse($request->isDebug());

        unset($request->options['debug']);
        AlibabaCloud::get('temp')->debug(false);
        self::assertFalse($request->isDebug());

        unset($request->options['debug'], AlibabaCloud::get('temp')->options['debug']);
        self::assertFalse($request->isDebug());
    }
}
