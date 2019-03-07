<?php

namespace AlibabaCloud\Client\Traits;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MockTrait
 *
 * @package AlibabaCloud\Client\Request\Traits
 * @mixin Request
 */
trait MockTrait
{
    /**
     * @var array
     */
    private static $mockQueue = [];

    /**
     * @param integer             $status
     * @param array               $headers
     * @param array|string|object $body
     */
    public static function mockResponse($status = 200, array $headers = [], $body = null)
    {
        if (is_array($body) || is_object($body)) {
            $body = json_encode($body);
        }

        self::$mockQueue[] = new Response($status, $headers, $body);
    }

    /**
     * @param string                 $message
     * @param RequestInterface       $request
     * @param ResponseInterface|null $response
     * @param \Exception|null        $previous
     * @param array                  $handlerContext
     */
    public static function mockRequestException(
        $message,
        RequestInterface $request,
        ResponseInterface $response = null,
        \Exception $previous = null,
        array $handlerContext = []
    ) {
        self::$mockQueue[] = new RequestException(
            $message,
            $request,
            $response,
            $previous,
            $handlerContext
        );
    }

    public static function clearMockQueue()
    {
        self::$mockQueue = [];
    }

    /**
     * @return bool
     */
    public static function hasMockQueue()
    {
        return (bool)self::$mockQueue;
    }

    /**
     * @return HandlerStack
     */
    public static function getMockQueue()
    {
        $mock = new MockHandler(self::$mockQueue);

        return HandlerStack::create($mock);
    }
}
