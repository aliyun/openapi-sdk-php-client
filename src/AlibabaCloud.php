<?php

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Traits\LogTrait;
use AlibabaCloud\Client\Traits\MockTrait;
use AlibabaCloud\Client\Traits\ClientTrait;
use AlibabaCloud\Client\Traits\HistoryTrait;
use AlibabaCloud\Client\Traits\RequestTrait;
use AlibabaCloud\Client\Traits\EndpointTrait;
use AlibabaCloud\Client\Traits\DefaultRegionTrait;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class AlibabaCloud
 *
 * @package   AlibabaCloud\Client
 * @mixin     \AlibabaCloud\ServiceResolverTrait
 */
class AlibabaCloud
{
    use ClientTrait;
    use DefaultRegionTrait;
    use EndpointTrait;
    use RequestTrait;
    use MockTrait;
    use HistoryTrait;
    use LogTrait;

    /**
     * Version of the Client
     */
    const VERSION = '1.3.1';

    /**
     * This static method can directly call the specific service.
     *
     * @param string $product
     * @param array  $arguments
     *
     * @codeCoverageIgnore
     * @return object
     * @throws ClientException
     */
    public static function __callStatic($product, $arguments)
    {
        $product = \ucfirst($product);

        $class = 'AlibabaCloud' . '\\' . $product . '\\' . $product;
        if (\class_exists($class)) {
            return new $class;
        }

        if (!\trait_exists("AlibabaCloud\\ServiceResolverTrait")) {
            throw new ClientException(
                'Please install alibabacloud/sdk to support product quick access.',
                SDK::SERVICE_NOT_FOUND
            );
        }

        throw new ClientException(
            "May not yet support product $product quick access, "
            . 'you can use [Alibaba Cloud Client for PHP] to send any custom '
            . 'requests: https://github.com/aliyun/openapi-sdk-php-client/blob/master/docs/3-Request-EN.md',
            SDK::SERVICE_NOT_FOUND
        );
    }
}
