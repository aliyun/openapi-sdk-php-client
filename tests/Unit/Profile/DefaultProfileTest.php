<?php

namespace AlibabaCloud\Client\Tests\Unit\Profile;

use AlibabaCloud\Client\Exception\ClientException;
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
     * @throws ClientException
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
     * @throws ClientException
     */
    public function testGetRamRoleArnProfile()
    {
        // Setup
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = 'access_key_id';
        $accessKeySecret = 'access_key_secret';
        $roleArn         = 'role_arn';
        $roleSessionName = 'role_session_name';

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
     * @throws ClientException
     */
    public function testGetEcsRamRoleProfile()
    {
        // Setup
        $regionId = 'cn-hangzhou';
        $roleName = 'EcsRamRoleTest';

        // Test
        $profile = DefaultProfile::getEcsRamRoleProfile($regionId, $roleName);

        // Assert
        $this->assertEquals($regionId, $profile->regionId);
        $this->assertEquals($roleName, $profile->getCredential()->getRoleName());
    }

    /**
     * @throws ClientException
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
