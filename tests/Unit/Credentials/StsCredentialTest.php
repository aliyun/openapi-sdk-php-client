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

namespace AlibabaCloud\Client\Tests\Unit\Credentials;

use AlibabaCloud\Client\Credentials\StsCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class StsCredentialTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\StsCredential
 */
class StsCredentialTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::getAccessKeyId
     * @covers ::getAccessKeySecret
     * @covers ::getSecurityToken
     * @covers ::__toString
     */
    public function testConstruct()
    {
        // Setup
        $accessKeyId     = 'accessKeyId';
        $accessKeySecret = 'accessKeySecret';
        $securityToken   = 'securityToken';

        // Test
        $credential = new StsCredential($accessKeyId, $accessKeySecret, $securityToken);

        // Assert
        $this->assertEquals($accessKeyId, $credential->getAccessKeyId());
        $this->assertEquals($accessKeySecret, $credential->getAccessKeySecret());
        $this->assertEquals($securityToken, $credential->getSecurityToken());
        $this->assertEquals(
            "$accessKeyId#$accessKeySecret#$securityToken",
            (string)$credential
        );
    }
}
