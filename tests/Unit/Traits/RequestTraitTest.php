<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class RequestTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\RequestTrait
 */
class RequestTraitTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function testRpcRequest()
    {
        self::assertInstanceOf(RpcRequest::class, AlibabaCloud::rpc());
    }

    /**
     * @throws ClientException
     */
    public function testRoaRequest()
    {
        self::assertInstanceOf(RoaRequest::class, AlibabaCloud::roa());
    }
}
