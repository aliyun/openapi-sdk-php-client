<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClustersForRegionRequest;

/**
 * Class RequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Feature\Request
 */
class RequestTest extends TestCase
{
    /**
     * @throws ClientException
     */
    protected function initializeClient()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->asDefaultClient()->regionId(\AlibabaCloud\Client\env('REGION_ID', 'cn-hangzhou'));
    }

    /**
     * @throws ClientException
     */
    public function testConstruct()
    {
        
        // Setup
        $this->initializeClient();
        $request = new DescribeClustersForRegionRequest();
        $request->pathParameter('region_id', $request->realRegionId());

        // Test
        $result = $request->connectTimeout(25)
            ->timeout(30)
            ->request();

        // Assert
        self::assertSame(200, $result->getStatusCode());
        self::assertTrue(is_array($result['clusters']));
        self::assertArrayHasKey('page_info', $result->toArray());
    }

    /**
     * @throws ClientException
     */
    public function testWithBearerTokenCredential()
    {
        
        // Setup
        $regionId = 'cn-hangzhou';
        $bearerToken = 'BEARER_TOKEN';
        AlibabaCloud::bearerTokenClient($bearerToken)
            ->name('BEARER_TOKEN')
            ->regionId($regionId);

        // CS uses AK authentication; verify Bearer headers without relying on service errors.
        AlibabaCloud::mockResponse(200, [], ['clusters' => [], 'page_info' => []]);
        try {
            $request = (new DescribeClustersForRegionRequest())
                ->client('BEARER_TOKEN')
                ->host('example.test')
                ->pathParameter('region_id', $regionId)
                ->connectTimeout(25)
                ->timeout(50);
            $request->request();

            static::assertSame($bearerToken, $request->options['headers']['x-acs-bearer-token']);
            static::assertSame('BEARERTOKEN', $request->options['headers']['x-acs-signature-type']);
            static::assertSame('/regions/' . $regionId . '/clusters', $request->uri->getPath());
        } finally {
            AlibabaCloud::cancelMock();
        }
    }

    /**
     * @throws ClientException
     */
    public function testWithNamedClient()
    {
        
        // Setup
        $regionId = 'cn-hangzhou';
        $accessKeyId = \getenv('ACCESS_KEY_ID');
        $accessKeySecret = \getenv('ACCESS_KEY_SECRET');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
            ->regionId($regionId)
            ->name(__METHOD__);

        // Test
        $result = (new DescribeClustersForRegionRequest())
            ->connectTimeout(25)
            ->timeout(30)
            ->client(__METHOD__)
            ->pathParameter('region_id', $regionId)
            ->request();

        // Assert
        self::assertSame(200, $result->getStatusCode());
        self::assertTrue(is_array($result['clusters']));
        self::assertArrayHasKey('page_info', $result->toArray());
    }

    /**
     * @throws ClientException
     */
    public function testROA()
    {
        
        // Setup
        $this->initializeClient();
        $request = new DescribeClustersForRegionRequest();
        $request->pathParameter('region_id', $request->realRegionId());

        // Test
        $result = $request->connectTimeout(25)
            ->timeout(30)
            ->request();

        // Assert
        static::assertSame(200, $result->getStatusCode());
        static::assertTrue(is_array($result['clusters']));
        static::assertArrayHasKey('page_info', $result->toArray());
    }

    /**
     * @throws ClientException
     */
    public function testAccept()
    {
        
        // Setup
        $roa = AlibabaCloud::roa();
        $rpc = AlibabaCloud::rpc();

        // Test
        $roa->accept('accept');
        $rpc->accept('accept');

        // Assert
        self::assertEquals('accept', $roa->options['headers']['Accept']);
        self::assertEquals('accept', $rpc->options['headers']['Accept']);
    }

}
