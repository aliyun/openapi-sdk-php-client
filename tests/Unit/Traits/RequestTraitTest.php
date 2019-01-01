<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\RequestTrait
 */
class RequestTraitTest extends TestCase
{
    public function testRpcRequest()
    {
        self::assertInstanceOf(RpcRequest::class, AlibabaCloud::rpcRequest());
    }

    public function testRoaRequest()
    {
        self::assertInstanceOf(RoaRequest::class, AlibabaCloud::roaRequest());
    }
}
