[English](./README.md) | 简体中文


<p align="center"><img src="./src/Files/Aliyun.svg"></p>
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
<a href="https://ci.appveyor.com/project/songshenzong/openapi-sdk-php-client/branch/master"><img src="https://ci.appveyor.com/api/projects/status/0l0msff7dwvt7cqg/branch/master?svg=true" alt="Appveyor Build Status"></a>
<a href="https://scrutinizer-ci.com/code-intelligence"><img src="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client/badges/code-intelligence.svg" alt="Code Intelligence Status"></a>
</p>


## 关于
**Alibaba Cloud Client for PHP** 是帮助 PHP 开发者管理凭据、发送请求的客户端工具，[Alibaba Cloud SDK for PHP][SDK] 由本工具提供底层支持。


## 在线示例
[API Explorer](https://api.aliyun.com) 提供在线调用阿里云产品，并动态生成 SDK 代码和快速检索接口等能力，能显著降低使用云 API 的难度。


## 快速开始

1. **阿里云帐户**  - 在您开始之前，您需要注册阿里云帐户并获取您的[凭证](https://usercenter.console.aliyun.com/#/manage/ak)。
1. **环境要求**  - 您的系统需要满足[环境要求](docs/0-Requirements-CN.md)），包括 **PHP> = 5.5**。 我们强烈建议使用cURL扩展，并使用TLS后端编译cURL 7.16.2+。
1. **安装依赖**  - 如果在您的系统上全局安装Composer，您可以在项目目录中运行以下内容，将 Alibaba Cloud Client for PHP 添加为依赖项：
   ```
   composer require alibabacloud/client
   ```
   请看 [安装](docs/1-Installation-CN.md) 有关通过 Composer 和其他方式安装的详细信息。


## 快速使用

### 创建客户端
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->asDefaultClient();
```

### ROA 请求
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

try {
    $result = AlibabaCloud::roa()
                          ->regionId('cn-hangzhou') // 指定请求的区域，不指定则使用客户端区域、默认区域
                          ->product('CS') // 指定产品
                          ->version('2015-12-15') // 指定产品版本
                          ->action('DescribeClusterServices') // 指定产品接口
                          ->serviceCode('cs') // 设置 ServiceCode 以备寻址，非必须
                          ->endpointType('openAPI') // 设置类型，非必须
                          ->method('GET') // 指定请求方式
                          ->host('cs.aliyun.com') // 指定域名则不会寻址，如认证方式为 Bearer Token 的服务则需要指定
                          ->pathPattern('/clusters/[ClusterId]/services') // 指定ROA风格路径规则
                          ->withClusterId('123456') // 为路径中参数赋值，方法名：with + 参数
                          ->request(); // 发起请求并返回结果对象，请求需要放在设置的最后面

    print_r($result->toArray());
    
} catch (ClientException $exception) {
    print_r($exception->getErrorMessage());
} catch (ServerException $exception) {
    print_r($exception->getErrorMessage());
}
```

### RPC 请求
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


## 文档
* [环境要求](docs/0-Requirements-CN.md)
* [安装](docs/1-Installation-CN.md)
* [客户端](docs/2-Client-CN.md)
* [请求](docs/3-Request-CN.md)
* [结果](docs/4-Result-CN.md)
* [区域](docs/5-Region-CN.md)
* [域名](docs/6-Host-CN.md)
* [SSL 验证](docs/7-Verify-CN.md)
* [调试](docs/8-Debug-CN.md)
* [测试](docs/9-Test-CN.md)


## 相关
* [阿里云服务 Regions & Endpoints][endpoints]
* [OpenAPI Explorer][open-api]
* [Packagist][packagist]
* [Composer][composer]
* [Guzzle中文文档][guzzle-docs]
* [最新源码][latest-release]


[SDK]: https://github.com/aliyun/openapi-sdk-php/blob/master/README-CN.md
[open-api]: https://api.aliyun.com
[latest-release]: https://github.com/aliyun/openapi-sdk-php-client
[guzzle-docs]: https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html
[composer]: https://getcomposer.org
[packagist]: https://packagist.org/packages/alibabacloud/sdk
[home]: https://home.console.aliyun.com
[aliyun]: https://www.aliyun.com
[regions]: https://help.aliyun.com/document_detail/40654.html
[endpoints]: https://developer.aliyun.com/endpoints
[cURL]: http://php.net/manual/zh/book.curl.php
[OPCache]: http://php.net/manual/zh/book.opcache.php
[xdebug]: http://xdebug.org
[OpenSSL]: http://php.net/manual/zh/book.openssl.php
[client]: https://github.com/aliyun/openapi-sdk-php-client
