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

namespace AlibabaCloud\Client\Tests\Unit\Regions;

use AlibabaCloud\Client\Regions\EndpointProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class EndpointProviderTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Regions
 *
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class EndpointProviderTest extends TestCase
{
    public function testFindProductDomain()
    {
        $this->assertEquals(
            'ecs-cn-hangzhou.aliyuncs.com',
            EndpointProvider::findProductDomain('cn-hangzhou', 'Ecs')
        );
        $this->assertEquals(
            'kms.me-east-1.aliyuncs.com',
            EndpointProvider::findProductDomain('me-east-1', 'kms')
        );
    }

    /**
     * Test for AddEndpoint
     */
    public function testAddEndpoint()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $product  = 'TestProduct';
        $domain   = 'testproduct.aliyuncs.com';

        // Test
        EndpointProvider::addEndpoint($regionId, $product, $domain);

        // Assert
        self::assertEquals($domain, EndpointProvider::findProductDomain($regionId, $product));
    }

    /**
     * Test for Null
     */
    public function testNull()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $product  = 'TestProduct2';

        // Test
        self::assertEquals('', EndpointProvider::findProductDomain($regionId, $product));
    }
}
