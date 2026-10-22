<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use Exception;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Monolog\Handler\StreamHandler;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClustersForRegionRequest;

/**
 * Class LogTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\RequestTrait
 */
class LogTraitTest extends TestCase
{
    /**
     * @throws ClientException
     * @throws Exception
     */
    public function testLogger()
    {
        $logFile = __DIR__ . '/../../../log.log';
        $logger  = new Logger('AlibabaCloud');
        $logger->pushHandler(new StreamHandler($logFile));
        AlibabaCloud::setLogger($logger);
        AlibabaCloud::setLogFormat('{start_time} "{method} {uri} HTTP/{version}" {code} {cost} {hostname} {pid} Custom field');

        // Setup
        $regionId    = 'cn-hangzhou';
        $bearerToken = 'BEARER_TOKEN';
        AlibabaCloud::bearerTokenClient($bearerToken)
                    ->name('BEARER_TOKEN')
                    ->regionId($regionId);
        AlibabaCloud::mockResponse(200, [], [
            'clusters' => [],
            'page_info' => ['page_number' => 1, 'page_size' => 10, 'total_count' => 0]
        ]);

        // Test
        try {
            (new DescribeClustersForRegionRequest())
                ->client('BEARER_TOKEN')
                ->host('example.test')
                ->pathParameter('region_id', $regionId)
                ->connectTimeout(25)
                ->timeout(30)
                ->request();
        } finally {
            AlibabaCloud::cancelMock();
        }

        $logContent = file_get_contents($logFile);
        self::assertNotFalse(strpos($logContent, 'Version=2015-12-15'));
        self::assertNotFalse(strpos($logContent, 'Custom field'));
    }
}
