<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClusterServicesRequest;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

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

        // Test
        try {
            (new  DescribeClusterServicesRequest())
                ->client('BEARER_TOKEN')
                ->withClusterId(\time())
                ->connectTimeout(25)
                ->timeout(30)
                ->request();
        } catch (ServerException $e) {
            // Assert
            $this->assertEquals('UnsupportedSignatureType', $e->getErrorCode());
        }

        $logContent = file_get_contents($logFile);
        self::assertNotFalse(strpos($logContent, 'Version=2015-12-15'));
        self::assertNotFalse(strpos($logContent, 'Custom field'));
    }
}
