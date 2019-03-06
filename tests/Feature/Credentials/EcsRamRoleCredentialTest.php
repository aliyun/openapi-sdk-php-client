<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\Dds\DescribeRegionsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class EcsRamRoleCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 */
class EcsRamRoleCredentialTest extends TestCase
{

    /**
     * @var string
     */
    private $clientName = 'EcsRamRoleCredentialTest';

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws ClientException
     */
    public function setUp()
    {
        parent::setUp();
        $regionId = 'cn-hangzhou';
        $roleName = 'EcsRamRoleTest';
        AlibabaCloud::ecsRamRoleClient($roleName)
                    ->regionId($regionId)
                    ->name($this->clientName);
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @throws ClientException
     */
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::del($this->clientName);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Timeout or instance does not belong to Alibaba Cloud
     * @throws ClientException
     */
    public function testGetSessionCredential()
    {
        try {
            (new DescribeRegionsRequest())->client($this->clientName)
                                          ->connectTimeout(20)
                                          ->timeout(25)
                                          ->request();
        } catch (ServerException $e) {
            self::assertContains(
                $e->getErrorMessage(),
                [
                    'Error in retrieving assume role credentials.',
                    'The role was not found in the instance',
                ]
            );
        }
    }
}
