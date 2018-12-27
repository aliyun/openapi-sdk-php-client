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
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client\Tests\Unit\Result;

use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class FormatTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Result
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class FormatTraitTest extends TestCase
{
    public function testXmlBad()
    {
        // Setup
        $request = (new RpcRequest())->format('XML');
        $result  = new Result(new Response(200, [], 'badFormat'), $request);

        // Assert
        self::assertEquals([], $result->toArray());
    }

    public function testArrayAccess()
    {
        // Setup
        $result        = new Result(new Response());
        $result['key'] = 'value';

        // Assert
        self::assertEquals('value', $result['key']);

        // Setup
        unset($result['key']);

        // Assert
        self::assertEquals(false, isset($result['key']));
    }

    public function testIteratorAggregate()
    {
        // Setup
        $result = new Result(new Response());

        // Assert
        self::assertInstanceOf(\ArrayIterator::class, $result->getIterator());
    }

    public function testToJson()
    {
        // Setup
        $result        = new Result(new Response());
        $time          = \time();
        $result[$time] = $time;

        // Assert
        self::assertEquals('{"' . $time . '":' . $time . '}', $result->toJson());
    }
}
