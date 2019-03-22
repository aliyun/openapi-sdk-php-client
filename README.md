English | [简体中文](./README-CN.md)


<p align="center"><img src="./src/Files/AlibabaCloud.svg"></p>
<p align="center">
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/composerlock" alt="composer.lock"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/license" alt="License"></a>
<br/>
<a href="https://codecov.io/gh/aliyun/openapi-sdk-php-client"><img src="https://codecov.io/gh/aliyun/openapi-sdk-php-client/branch/master/graph/badge.svg" alt="codecov"></a>
<a href="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client"><img src="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client/badges/quality-score.png" alt="Scrutinizer Code Quality"></a>
<a href="https://travis-ci.org/aliyun/openapi-sdk-php-client"><img src="https://travis-ci.org/aliyun/openapi-sdk-php-client.svg?branch=master" alt="Travis Build Status"></a>
<a href="https://ci.appveyor.com/project/aliyun/openapi-sdk-php-client/branch/master"><img src="https://ci.appveyor.com/api/projects/status/699v083woth7mj85/branch/master?svg=true" alt="Appveyor Build Status"></a>
<a href="https://scrutinizer-ci.com/code-intelligence"><img src="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client/badges/code-intelligence.svg" alt="Code Intelligence Status"></a>
</p>

## About
**Alibaba Cloud Client for PHP** is a client tool that helps PHP developers manage credentials and send requests, [Alibaba Cloud SDK for PHP][SDK] dependency on this tool.


## Online Demo
[API Explorer](https://api.aliyun.com) provides the ability to call the cloud product OpenAPI online, and dynamically generate SDK Example code and quick retrieval interface, which can significantly reduce the difficulty of using the cloud API.


## Getting Started

1. **Alibaba Cloud Account** – Before you begin, you need to sign up for an Alibaba Cloud account and retrieve your [Credentials](https://usercenter.console.aliyun.com/#/manage/ak).
1. **Requirements** – Your system will need to meet the [Requirements](docs/0-Requirements-EN.md), including having **PHP >= 5.5**. We highly recommend having it compiled with the cURL extension and cURL 7.16.2+.
1. **Install Dependency** – If Composer is installed globally on your system, you can run the following in the base directory of your project to add the Alibaba Cloud Client for PHP as a dependency:
   ```
   composer require alibabacloud/client
   ```
   Please see the
   [Installation](docs/1-Installation-EN.md) for more detailed information about installing the Alibaba Cloud Client for PHP through Composer and other means.


## Quick Examples

### Create Client
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->asDefaultClient();
```

### ROA Request
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

try {
    $result = AlibabaCloud::roa()
                          ->regionId('cn-hangzhou') // Specify the requested regionId, if not specified, use the client regionId, then default regionId
                          ->product('CS') // Specify product
                          ->version('2015-12-15') // Specify product version
                          ->action('DescribeClusterServices') // Specify product interface
                          ->serviceCode('cs') // Set ServiceCode for addressing, optional
                          ->endpointType('openAPI') // Set type, optional
                          ->method('GET') // Set request method
                          ->host('cs.aliyun.com') // Location Service will not be enabled if the host is specified. For example, service with a Certification type-Bearer Token should be specified
                          ->pathPattern('/clusters/[ClusterId]/services') // Specify path rule with ROA-style
                          ->withClusterId('123456') // Assign values to parameters in the path. Method: with + Parameter
                          ->request(); // Make a request and return to result object. The request is to be placed at the end of the setting
                          
    print_r($result->toArray());
    
} catch (ClientException $exception) {
    print_r($exception->getErrorMessage());
} catch (ServerException $exception) {
    print_r($exception->getErrorMessage());
}
```

### RPC Request
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

try {
    $result = AlibabaCloud::rpc()
                          ->product('Cdn')
                          ->version('2014-11-11')
                          ->action('DescribeCdnService')
                          ->method('POST')
                          ->request();
    
    print_r($result->toArray());
    
} catch (ClientException $exception) {
    print_r($exception->getErrorMessage());
} catch (ServerException $exception) {
    print_r($exception->getErrorMessage());
}
```


## Documentation
* [Requirements](docs/0-Requirements-EN.md)
* [Installation](docs/1-Installation-EN.md)
* [Client](docs/2-Client-EN.md)
* [Request](docs/3-Request-EN.md)
* [Result](docs/4-Result-EN.md)
* [Region](docs/5-Region-EN.md)
* [Host](docs/6-Host-EN.md)
* [SSL Verify](docs/7-Verify-EN.md)
* [Debug](docs/8-Debug-EN.md)
* [Test](docs/9-Test-EN.md)


## References
* [Alibaba Cloud Regions & Endpoints][endpoints]
* [OpenAPI Explorer][open-api]
* [Packagist][packagist]
* [Composer][composer]
* [Guzzle Documentation][guzzle-docs]
* [Latest Release][latest-release]


[SDK]: https://github.com/aliyun/openapi-sdk-php
[open-api]: https://api.alibabacloud.com
[latest-release]: https://github.com/aliyun/openapi-sdk-php-client
[guzzle-docs]: http://docs.guzzlephp.org/en/stable/request-options.html
[composer]: https://getcomposer.org
[packagist]: https://packagist.org/packages/alibabacloud/sdk
[home]: https://home.console.aliyun.com
[alibabacloud]: https://www.alibabacloud.com
[regions]: https://www.alibabacloud.com/help/doc-detail/40654.html
[endpoints]: https://developer.aliyun.com/endpoints
[cURL]: http://php.net/manual/en/book.curl.php
[OPCache]: http://php.net/manual/en/book.opcache.php
[xdebug]: http://xdebug.org
[OpenSSL]: http://php.net/manual/en/book.openssl.php
[client]: https://github.com/aliyun/openapi-sdk-php-client
