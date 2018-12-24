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
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\Requests\AssumeRoleRequest;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKeyRequest;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 * @coversDefaultClass \AlibabaCloud\Client\Request\Request
 */
class ClientTraitTest extends TestCase
{

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testMergeOptionsIntoClient()
    {
        // Setup
        $clientName = __METHOD__;
        $expected   = 'i \'m request';

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->options([
                                  'headers' => [
                                      'client' => 'client',
                                  ],
                              ])
                    ->name($clientName);

        $request = (new DescribeCdnServiceRequest())->client($clientName)
                                                    ->options(['request1' => 'request'])
                                                    ->options(['request2' => 'request2'])
                                                    ->options([
                                                                  'headers' => [
                                                                      'client' => $expected,
                                                                  ],
                                                              ]);
        $request->mergeOptionsIntoClient();

        // Assert
        $this->assertEquals($expected, $request->options['headers']['client']);
    }

    public function testCredential()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new DescribeCdnServiceRequest())->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }

    public function testCredentialOnAssumeRoleRequest()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new AssumeRoleRequest(new RamRoleArnCredential(
                                              'key',
                                              'secret',
                                              'arn',
                                              'name'
                                          )))->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }

    public function testCredentialOnGenerateSessionAccessKeyRequest()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new GenerateSessionAccessKeyRequest(new RsaKeyPairCredential(
                                                            'key',
                                                            VirtualRsaKeyPairCredential::ok()
                                                        )))->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }
}
