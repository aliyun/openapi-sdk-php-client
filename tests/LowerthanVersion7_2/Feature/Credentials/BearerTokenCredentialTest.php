<?php

namespace AlibabaCloud\Client\Tests\LowerthanVersion7_2\Feature\Credentials;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\CCC\ListPhoneNumbersRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeAccessPointsRequest;

/**
 * Class BearerTokenCredentialTest
 *
 * @package   AlibabaCloud\Client\Tests\LowerthanVersion7_2\Feature\Credentials
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
        $regionId    = 'cn-hangzhou';
        $bearerToken =
            'eyJhbGciOiJSUzI1NiIsImsyaWQiOiJlNE92NnVOUDhsMEY2RmVUMVhvek5wb1NBcVZLblNGRyIsImtpZCI6IkpDOXd4enJocUowZ3RhQ0V0MlFMVWZldkVVSXdsdEZodWk0TzFiaDY3dFUifQ.N3plS0w2cm83YzhtVzJqSkI0U0JIMldzNW45cFBOSWdNellvQ3VpZGV5NzRVOHNsMkJUWTVULzl3RDdkbzhHQkorM3dvclg1SGY1STZXL1FjaVhLVnc5ck5YeVNYanBuK2N6UkN1SnRRc3FRMGJIVTF4cVVjUDVRNUJpK2JsSWxZdlowZ2VWSzYvS2pzcVNjWHJLSlVvWkNnWE0wWGJZZ0NCVm1BUlNXS1plUnNzdnAvUmwwV01tSFFkWmlOMGtKV0o5TllQU3M0QU1aenpHVTdUY1BnYlhIVy9uTmdMY1JVSytROXlrPQ.kvZes7-6IU-xjOzK1goPPjODz1XLt73yCmDLSpRwzlz3d9A_uYvbQK0HHltVKo0K0dI0wJOfpCeOHJlrV0m4RI4bynL9ltl31rscPhQ-G4Ybqw4KXVBZCIzjSqzWcniIWnGWl-TpOy0Y7sAcJmp0Lg2ndu_shGqiTP6DTVBNV8f94mveHmRqouLxr2OKMvCyxTV1zUEJmC-JnZaljfNG-i483qG8Hm60CwAjM91FTGib3eXGzjJa3XOOY7zpZTrvahBYFpyrVhRuvDvRs6tLKVAL_7bYwCIo_tdh9rhRmFtyq0k2iykZQJmAIlDMt-VENP7hJTH62uUQzNLQ28ISTQ';
        AlibabaCloud::bearerTokenClient($bearerToken)
                    ->regionId($regionId)
                    ->name($this->clientName);
    }

    /**
     * @throws ClientException
     */
    public function tearDown()
    {
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
