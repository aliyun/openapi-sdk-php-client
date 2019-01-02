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
