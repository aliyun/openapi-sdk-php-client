[← Client](Client-EN.md) | Request[(中文)](Request-CN.md) | [Result →](Result-EN.md)
***

# Request

Each request supports Chain Settings, Construct Settings, and so on. In addition to the requesting parameters, the `Client`, `Timeout`, `Region`, `Debug Mode` et al. can be set separately.For the constructing and `options()` parameters, please refer to: [Guzzle Request Options][guzzle-docs]

> The [Alibaba Cloud SDK for PHP][SDK] provides a quick access method for products based on the inheritance of Alibaba Cloud Client for PHP, making it easier for you to use Alibaba Cloud services.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

try {
    // Chain calls and send ROA request
    $roaResult = AlibabaCloud::roa()
                             ->client('client1') // Specify client, if not, the default client is used by default
                             ->regionId('cn-hangzhou') // Specify the requested regionId, if not specified, use the client regionId, then default regionId
                             ->product('CS') // Specify product
                             ->version('2015-12-15') // Specify product version
                             ->action('DescribeClusterServices') // Specify product interface
                             ->serviceCode('cs') // Set ServiceCode for addressing, optional
                             ->endpointType('openAPI') // Set type, optional
                             ->method('GET') // Set request method
                             ->host('cs.aliyun.com') // Location Service will not be enabled if the host is specified. For example, service with a Certification type-Bearer Token should be specified
                             ->pathPattern('/clusters/[ClusterId]/services') // Specify path rule with ROA-style
                             ->connectTimeout(0.1) // 10 milliseconds of connection timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->timeout(0.1) // 10 milliseconds of timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->debug(true) // Enable Debug, details will be output under CLI
                             ->withClusterId('123456') // Assign values to parameters in the path. Method: with + Parameter
                             ->request(); // Make a request and return to result object. The request is to be placed at the end of the setting

    // Chain calls and send RPC request
    $rpcResult = AlibabaCloud::rpc()
                             ->client('client1') // Specify client, if not, the default client is used by default
                             ->product('Cdn')
                             ->version('2014-11-11')
                             ->action('DescribeCdnService')
                             ->method('POST')
                             ->connectTimeout(0.1) // 10 milliseconds of connection timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->timeout(0.1) // 10 milliseconds of timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->debug(true) // Enable Debug, details will be output under CLI
                             ->request();// Make a request and return to result object. The request is to be placed at the end of the setting
        

    // Construct calls and send RPC request
    $request3 = AlibabaCloud::rpc([
                                 'debug'           => true,
                                 'timeout'         => 0.01,
                                 'connect_timeout' => 0.01,
                                         'query'   => [
                                               'Product' => 'Cdn',
                                               'Version' => '2014-11-11',
                                               'Action'  => 'DescribeCdnService',
                                         ],
                               ]);
    $result3  = $request3->request();

    // Priority of setting
    $result4 = AlibabaCloud::rpc([
                                   'debug'           => true,
                                   'timeout'         => 0.01,
                                   'connect_timeout' => 0.01,
                                   'query'           => [
                                      'Product' => 'Cdn',
                                      'Version' => '2014-11-11',
                                      'Action'  => 'DescribeCdnService',
                                   ],
                                ])->options([
                                                // All parameters can be also set by Options method or reset
                                                'query' => [
                                                    'Product'      => 'I will overwrite this value in constructor',
                                                    'Version'      => 'I am new value',
                                                ],
                                              ])
                                   ->options([
                                                // The Options method can be called multiple times
                                                'query' => [
                                                    'Product' => 'I will overwrite the previous value',
                                                    'Version' => 'I will overwrite the previous value',
                                                    'Action'  => 'I will overwrite the previous value',
                                                    'New'     => 'I am new value',
                                                ],
                                              ])
                                   ->debug(false) // Overwrite the true of the former
                                   ->timeout(0.02) // Overwrite the 0.01 of the former
                                   ->request();
    
} catch (ClientException $exception) {
    // Get error message
    print_r($exception->getErrorMessage());
} catch (ServerException $exception) {
    // Get error code
    print_r($exception->getErrorCode());
    // Get Request Id
    print_r($exception->getRequestId());
    // Get error message
    print_r($exception->getErrorMessage());
    // Get result object
    print_r($exception->getResult());
    // Get response object
    print_r($exception->getResult()->getResponse());
    // Get request object
    print_r($exception->getResult()->getRequest());
}
```

***
[← Client](Client-EN.md) | Request[(中文)](Request-CN.md) | [Result →](Result-EN.md)

[SDK]: https://github.com/aliyun/openapi-sdk-php
[guzzle-docs]: http://docs.guzzlephp.org/en/stable/request-options.html
