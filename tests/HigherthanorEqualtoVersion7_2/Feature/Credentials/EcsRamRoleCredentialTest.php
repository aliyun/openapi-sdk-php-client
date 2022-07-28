<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\Dds\DescribeRegionsRequest;

/**
 * Class EcsRamRoleCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Feature\Credentials
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
    public function setUp(): void
    {
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
    public function tearDown(): void
    {
        AlibabaCloud::del($this->clientName);
    }

    /**
     * @throws ClientException
     */
    public function testGetSessionCredential()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Timeout or instance does not belong to Alibaba Cloud');
        try {
            (new DescribeRegionsRequest())->client($this->clientName)
                                          ->connectTimeout(25)
                                          ->timeout(30)
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
