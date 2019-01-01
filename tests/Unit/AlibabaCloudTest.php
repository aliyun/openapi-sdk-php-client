<?php

namespace AlibabaCloud\Client\Tests\Unit;

use AlibabaCloud\Client\AlibabaCloud;
use PHPUnit\Framework\TestCase;

/**
 * Class AlibabaCloudTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class AlibabaCloudTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        AlibabaCloud::flush();
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Please install alibabacloud/sdk first.
     */
    public function testCallStatic()
    {
        AlibabaCloud::Ecs();
    }
}
