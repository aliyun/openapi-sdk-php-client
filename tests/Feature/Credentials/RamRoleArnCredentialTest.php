<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RamRoleArnCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 */
class RamRoleArnCredentialTest extends TestCase
{

    /**
     * @var string
     */
    private $clientName = 'RamRoleArnCredentialTest';

    /**
     * @throws ClientException
     */
    public function setUp()
    {
        parent::setUp();
        $regionId        = 'cn-hangzhou';
        $accessKeyId     = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        $roleArn         = 'acs:ram::1325847523475998:role/ecsramroletest';
        $roleSessionName = 'role_session_name';
        $policy          = '{
    "Version": "1",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": "ecs:Describe*",
            "Resource": "acs:ecs:cn-hangzhou:*:*"
        },
        {
            "Effect": "Allow",
            "Action": [
                "oss:ListObjects",
                "oss:GetObject"
            ],
            "Resource": [
                "acs:oss:*:*:mybucket",
                "acs:oss:*:*:mybucket/*"
            ],
            "Condition":{
                "IpAddress": {
                    "acs:SourceIp": ["42.120.88.10", "42.120.66.0/24"]
                }
            }
        }
    ]
}';
        AlibabaCloud::ramRoleArnClient(
            $accessKeyId,
            $accessKeySecret,
            $roleArn,
            $roleSessionName,
            $policy
        )->regionId($regionId)->name($this->clientName);
    }

    /**
     * @throws ClientException
     */
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::del($this->clientName);
    }

    /**
     * @throws ClientException
     */
    public function testEcs()
    {
        try {
            $result = (new DescribeAccessPointsRequest())
                ->client($this->clientName)
                ->connectTimeout(25)
                ->timeout(30)
                ->request();
            $this->assertTrue(isset($result['AccessPointSet']));
        } catch (ServerException $e) {
            self::assertEquals(
                'You are not authorized to do this action. You should be authorized by RAM.',
                $e->getErrorMessage()
            );
        }
    }
}
