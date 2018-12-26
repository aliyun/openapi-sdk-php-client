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
 * Class DeprecatedTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class DeprecatedTraitTest extends TestCase
{
    public function testMethods()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        $request = (new RoaRequest())
            ->client($clientName)
            ->putDomainParameters('putDomainParameters', 'putDomainParameters');

        // Assert
        self::assertEquals('putDomainParameters', $request->options['form_params']['putDomainParameters']);
    }
}
