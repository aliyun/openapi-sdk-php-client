<?php

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Traits\ClientTrait;
use AlibabaCloud\Client\Traits\EndpointTrait;
use AlibabaCloud\Client\Traits\RegionTrait;
use AlibabaCloud\Client\Traits\RequestTrait;

/**
 * Class AlibabaCloud
 *
 * @package   AlibabaCloud\Client
 * @mixin     \AlibabaCloud\ServiceResolverTrait
 */
class AlibabaCloud
{
    use ClientTrait;
    use RegionTrait;
    use EndpointTrait;
    use RequestTrait;

    /**
     * Version of the Client
     */
    const VERSION = '1.0.14';

    /**
     * This static method can directly call the specific service.
     *
     * @param string $serviceName
     * @param array  $arguments
     *
     * @codeCoverageIgnore
     * @return object
     * @throws ClientException
     */
    public static function __callStatic($serviceName, $arguments)
    {
        $serviceName = \ucfirst($serviceName);

        $class = 'AlibabaCloud' . '\\' . $serviceName . '\\' . $serviceName;
        if (\class_exists($class)) {
            return new $class;
        }

        if (!\trait_exists("AlibabaCloud\\ServiceResolverTrait")) {
            throw new ClientException(
                'Please install alibabacloud/sdk to support product quick access.',
                \ALIBABA_CLOUD_SERVICE_NOT_FOUND
            );
        }

        throw new ClientException(
            "May not yet support product $serviceName quick access, "
            . 'you can use [Alibaba Cloud Client for PHP] to send any custom '
            . 'requests: https://github.com/aliyun/openapi-sdk-php-client#request',
            \ALIBABA_CLOUD_SERVICE_NOT_FOUND
        );
    }
}
