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

use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class RsaKeyPaireCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Credentials\RsaKeyPairCredential
 */
class RsaKeyPaireCredentialTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::getPublicKeyId
     * @covers ::getPrivateKey
     * @covers ::__toString
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testConstruct()
    {
        // Setup
        $publicKeyId    = \getenv('PUBLIC_KEY_ID');
        $privateKeyFile = VirtualRsaKeyPairCredential::privateKeyFileUrl();

        // Test
        $credential = new RsaKeyPairCredential($publicKeyId, $privateKeyFile);

        // Assert
        $this->assertEquals($publicKeyId, $credential->getPublicKeyId());
        $this->assertStringEqualsFile($privateKeyFile, $credential->getPrivateKey());
        $this->assertEquals(
            "publicKeyId#$publicKeyId",
            (string)$credential
        );
    }

    /**
     * @covers                   ::__construct
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage file_get_contents(/no/no.no): failed to open stream: No such file or directory
     */
    public function testException()
    {
        // Setup
        $publicKeyId    = \getenv('PUBLIC_KEY_ID');
        $privateKeyFile = '/no/no.no';

        // Test
        new RsaKeyPairCredential($publicKeyId, $privateKeyFile);
    }
}
