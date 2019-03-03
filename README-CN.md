[English](./README.md) | 简体中文


<p align="center"><img src="./src/Files/Aliyun.svg"></p>
<p align="center">
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/license" alt="License"></a>
<br/>
<a href="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client"><img src="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client/badges/quality-score.png" alt="Scrutinizer Code Quality"></a>
<a href="https://travis-ci.org/aliyun/openapi-sdk-php-client"><img src="https://travis-ci.org/aliyun/openapi-sdk-php-client.svg?branch=master" alt="Travis Build Status"></a>
<a href="https://ci.appveyor.com/project/songshenzong/openapi-sdk-php-client/branch/master"><img src="https://ci.appveyor.com/api/projects/status/0l0msff7dwvt7cqg/branch/master?svg=true" alt="Appveyor Build Status"></a>
<a href="https://codecov.io/gh/aliyun/openapi-sdk-php-client"><img src="https://codecov.io/gh/aliyun/openapi-sdk-php-client/branch/master/graph/badge.svg" alt="codecov"></a>
<a href="https://scrutinizer-ci.com/code-intelligence"><img src="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client/badges/code-intelligence.svg" alt="Code Intelligence Status"></a>
</p> 


## 关于
**Alibaba Cloud Client for PHP** 是帮助 PHP 开发者管理凭据、发送请求的客户端工具，[Alibaba Cloud SDK for PHP][SDK] 由本工具提供底层支持。


## 要求
- 您必须使用 PHP 5.5.0 或更高版本。
- 如果您使用了 `RsaKeyPair` 客户端（仅支持日本站），还需要 [OpenSSL PHP 扩展][OpenSSL]。


## 建议
- 使用 [Composer][composer] 并优化自动加载 `composer dump-autoload --optimize`
- 安装 [cURL][cURL] 7.16.2 或更高版本
- 使用 [OPCache][OPCache]
- 生产环境中不要使用 [Xdebug][xdebug]


## 在线示例
[API Explorer](https://api.aliyun.com) 提供在线调用阿里云产品，并动态生成 SDK 代码和快速检索接口等能力，能显著降低使用云 API 的难度，强烈推荐使用。

<a href="https://api.aliyun.com" target="api_explorer">
  <img src="https://img.alicdn.com/tfs/TB12GX6zW6qK1RjSZFmXXX0PFXa-744-122.png" width="180" />
</a>


## 安装
1. 下载并安装 Composer（Windows 用户请下载并运行 [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)）
```bash
curl -sS https://getcomposer.org/installer | php
```

2. 执行 Composer 命令安装 Alibaba Cloud Client for PHP 的最新稳定版本
```bash
php -d memory_limit=-1 composer.phar require alibabacloud/client
```

3. 在代码中引入 Composer 自动加载工具
```php
<?php

require __DIR__ . '/vendor/autoload.php'; 
```


## 快速开始
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

// 创建 AccessKey 客户端
AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->asDefaultClient();

try {
    // 链式调用发送 ROA 风格请求
    $roaResult = AlibabaCloud::roa()
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

    // 链式调用发送 RPC 风格请求
    $rpcResult = AlibabaCloud::rpc()
                             ->product('Cdn')
                             ->version('2014-11-11')
                             ->action('DescribeCdnService')
                             ->method('POST')
                             ->request();
    
} catch (ClientException $exception) {
    // 获取错误消息
    print_r($exception->getErrorMessage());
} catch (ServerException $exception) {
    // 获取错误代码
    print_r($exception->getErrorCode());
    // 获取 Request Id
    print_r($exception->getRequestId());
    // 获取错误消息
    print_r($exception->getErrorMessage());
    // 获取结果对象
    print_r($exception->getResult());
    // 获取响应对象
    print_r($exception->getResult()->getResponse());
    // 获取请求对象
    print_r($exception->getResult()->getRequest());
}
```


## 文档
* [安装](./docs/Installation-CN.md)
* [客户端](./docs/Client-CN.md)
* [请求](./docs/Request-CN.md)
* [结果](./docs/Result-CN.md)
* [区域](./docs/Region-CN.md)
* [域名](./docs/Host-CN.md)
* [调试](./docs/Debug-CN.md)


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
[composer]: http://getcomposer.org
[packagist]: https://packagist.org/packages/alibabacloud/sdk
[ak]: https://usercenter.console.aliyun.com/#/manage/ak
[home]: https://home.console.aliyun.com
[ram]: https://ram.console.aliyun.com/users
[permissions]: https://ram.console.aliyun.com/permissions
[aliyun]: https://www.aliyun.com
[endpoints]: https://developer.aliyun.com/endpoints
[cURL]: http://php.net/manual/zh/book.curl.php
[OPCache]: http://php.net/manual/zh/book.opcache.php
[xdebug]: http://xdebug.org
[OpenSSL]: http://php.net/manual/zh/book.openssl.php
[RAM Role]: https://ram.console.aliyun.com/#/role/list
[client]: https://github.com/aliyun/openapi-sdk-php-client
