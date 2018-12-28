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

use AlibabaCloud\Client\Request\RoaRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class DeprecatedRoaTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class DeprecatedRoaTraitTest extends TestCase
{
    public function testGetUriPattern()
    {
        // Setup
        $request = new RoaRequest();

        // Assert
        self::assertEquals(null, $request->pathPattern);
        self::assertEquals(null, $request->getUriPattern());

        // Setup
        $clientName = __METHOD__;

        // Test
        $request->client($clientName)
                ->setUriPattern('/setUriPattern');

        // Assert
        self::assertEquals('/setUriPattern', $request->pathPattern);
        self::assertEquals('/setUriPattern', $request->getUriPattern());
    }

    public function testGetPathParameters()
    {
        // Setup
        $request = new RoaRequest();

        // Assert
        self::assertEquals([], $request->pathParameters);
        self::assertEquals([], $request->getPathParameters());

        // Setup
        $clientName = __METHOD__;

        // Test
        $request->client($clientName)
                ->putPathParameter('putPathParameter', 'putPathParameter');

        // Assert
        self::assertEquals('putPathParameter', $request->pathParameters['putPathParameter']);
        self::assertEquals('putPathParameter', $request->getPathParameters()['putPathParameter']);
    }
}
