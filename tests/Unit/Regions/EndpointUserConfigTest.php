<?php

namespace AlibabaCloud\Client\Tests\Unit\Regions;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class LocationServiceTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Endpoint
 */
class EndpointUserConfigTest extends TestCase
{
    public function testAddHost()
    {
        // Setup
        $product  = 'test_add_host_mock_product';
        $regionId = 'test_add_host_mock_regionId';
        $host     = 'test_add_host_mock_host';

        AlibabaCloud::rpc()->regionId($regionId)->product($product);

        // Test addHost with empty param
        try {
            AlibabaCloud::addHost($product, '', $regionId);
        } catch (ClientException $exception) {
            self::assertEquals($exception->getMessage(), 'Host cannot be empty');
        }
        self::assertEquals(AlibabaCloud::resolveHostByUserConfig($product, $regionId), '');

        // Test addHost
        AlibabaCloud::addHost($product, $host, $regionId);
        self::assertEquals(AlibabaCloud::resolveHostByUserConfig($product, $regionId), $host);
    }
}