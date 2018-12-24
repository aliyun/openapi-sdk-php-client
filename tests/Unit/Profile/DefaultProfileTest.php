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

namespace AlibabaCloud\Client\Tests\Unit\Profile;

use AlibabaCloud\Client\Profile\DefaultProfile;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultProfileTest
 *
 * @package      AlibabaCloud\Client\Tests\Unit\Profile
 *
 * @author       Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright    Alibaba Group
 * @license      http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link         https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Profile\DefaultProfile
 */
class DefaultProfileTest extends TestCase
{
    /**
     * @covers ::getProfile
     */
    public function testGetProfile()
    {
        // Setup
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');

        // Test
        $profile = DefaultProfile::getProfile($regionId, $accessKeyId, $accessKeySecret);

        // Assert
        $this->assertEquals($regionId, $profile->regionId);
        $this->assertEquals($accessKeyId, $profile->getCredential()->getAccessKeyId());
        $this->assertEquals($accessKeySecret, $profile->getCredential()->getAccessKeySecret());
    }

    /**
     * @covers ::getRamRoleArnProfile
     */
    public function testGetRamRoleArnProfile()
    {
        // Setup
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        $roleArn         = \getenv('ROLE_ARN');
        $roleSessionName = \getenv('ROLE_SESSION_NAME');

        // Test
        $profile = DefaultProfile::getRamRoleArnProfile(
            $regionId,
            $accessKeyId,
            $accessKeySecret,
            $roleArn,
            $roleSessionName
        );

        // Assert
        $this->assertEquals($regionId, $profile->regionId);
        $this->assertEquals($accessKeyId, $profile->getCredential()->getAccessKeyId());
        $this->assertEquals($accessKeySecret, $profile->getCredential()->getAccessKeySecret());
        $this->assertEquals($roleArn, $profile->getCredential()->getRoleArn());
        $this->assertEquals($roleSessionName, $profile->getCredential()->getRoleSessionName());
    }

    /**
     * @covers ::getEcsRamRoleProfile
     */
    public function testGetEcsRamRoleProfile()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $roleName = \getenv('ECS_ROLE_NAME');

        // Test
        $profile = DefaultProfile::getEcsRamRoleProfile($regionId, $roleName);

        // Assert
        $this->assertEquals($regionId, $profile->regionId);
        $this->assertEquals($roleName, $profile->getCredential()->getRoleName());
    }

    /**
     * @covers ::getBearerTokenProfile
     */
    public function testGetBearerTokenProfile()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $token    = 'token';

        // Test
        $profile = DefaultProfile::getBearerTokenProfile($regionId, $token);

        // Assert
        $this->assertEquals($regionId, $profile->regionId);
        $this->assertEquals($token, $profile->getCredential()->getBearerToken());
    }
}
