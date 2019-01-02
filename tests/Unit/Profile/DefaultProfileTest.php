<?php

namespace AlibabaCloud\Client\Tests\Unit\Profile;

use AlibabaCloud\Client\Profile\DefaultProfile;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultProfileTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Profile
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
