<?php

namespace AlibabaCloud\Client\Tests\Feature\Credentials;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\CCC\ListPhoneNumbersRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class BearerTokenCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Credentials
 */
class BearerTokenCredentialTest extends TestCase
{

    /**
     * @var string
     */
    protected $clientName = 'BearerTokenCredentialTest';

    /**
     * @throws ClientException
     */
    public function setUp()
    {
        parent::setUp();
        $regionId    = 'cn-hangzhou';
        $bearerToken = \getenv('BEARER_TOKEN');
        AlibabaCloud::bearerTokenClient($bearerToken)
                    ->regionId($regionId)
                    ->name($this->clientName);
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
    public function testCCC()
    {
        try {
            (new ListPhoneNumbersRequest())
                ->client($this->clientName)
                ->withInstanceId(\getenv('CC_INSTANCE_ID'))
                ->withOutboundOnly(true)
                ->scheme('https')
                ->host('ccc.cn-shanghai.aliyuncs.com')
                ->options([
                              'verify' => false,
                          ])
                ->connectTimeout(25)
                ->timeout(30)
                ->debug(true)
                ->request();
        } catch (ServerException $e) {
            $result = $e->getResult();
            self::assertEquals(
                'InvalidBearerTokenException: Bearertoken has expired',
                $result['Message']
            );
        }
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ServerException
     * @expectedExceptionMessageRegExp /UnsupportedSignatureType: This signature type is not supported./
     * @throws ClientException
     */
    public function testEcs()
    {
        (new DescribeAccessPointsRequest())
            ->client($this->clientName)
            ->connectTimeout(25)
            ->timeout(30)
            ->request();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ServerException
     * @expectedExceptionMessageRegExp /UnsupportedSignatureType: This signature type is not supported./
     * @throws ClientException
     */
    public function testCdn()
    {
        (new DescribeCdnServiceRequest())->client($this->clientName)
                                         ->connectTimeout(25)
                                         ->timeout(30)
                                         ->request();
    }
}
