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

namespace AlibabaCloud\Client\Tests\Unit\Signature;

use AlibabaCloud\Client\Signature\BearerTokenSignature;
use PHPUnit\Framework\TestCase;

/**
 * Class BearerTokenSignatureTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Signature
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Signature\BearerTokenSignature
 */
class BearerTokenSignatureTest extends TestCase
{

    /**
     * @covers ::sign
     * @covers ::getMethod
     * @covers ::getVersion
     * @covers ::getType
     */
    public function testBearerTokenSignature()
    {
        // Setup
        $string          = 'this is a BearToken test.';
        $accessKeySecret = 'accessKeySecret';
        $expected        = null;

        // Test
        $signature = new BearerTokenSignature();

        // Assert
        $this->assertInstanceOf(BearerTokenSignature::class, $signature);
        $this->assertEquals($expected, $signature->sign($string, $accessKeySecret));
        $this->assertEquals('', $signature->getMethod());
        $this->assertEquals('1.0', $signature->getVersion());
        $this->assertEquals('BEARERTOKEN', $signature->getType());
    }
}
