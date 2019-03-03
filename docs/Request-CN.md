[← 客户端](Client-CN.md) | 请求[(English)](Request-EN.md) | [结果 →](Result-CN.md)
***

## 请求

每个请求都支持链式设置、构造设置等，除请求参数外，还可单独设置 `客户端`、 `超时`、 `区域`、 `调试模式` 等。构造参数和 `options()` 参数请参考：[请求选项 Guzzle中文文档][guzzle-docs]

> [Alibaba Cloud SDK for PHP][SDK] 在继承 Alibaba Cloud Client for PHP 的基础上提供了产品快捷访问方法，让您更加轻松的使用阿里云服务。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
        
try {
    // 链式调用发送 ROA 风格请求
    $roaResult = AlibabaCloud::roa()
                             ->client('client1') // 指定发送请求的客户端，不指定默认使用默认客户端
                             ->regionId('cn-hangzhou') // 指定请求的区域，不指定则使用客户端区域、默认区域
                             ->product('CS') // 指定产品
                             ->version('2015-12-15') // 指定产品版本
                             ->action('DescribeClusterServices') // 指定产品接口
                             ->serviceCode('cs') // 设置 ServiceCode 以备寻址，非必须
                             ->endpointType('openAPI') // 设置类型，非必须
                             ->method('GET') // 指定请求方式
                             ->host('cs.aliyun.com') // 指定域名则不会寻址，如认证方式为 Bearer Token 的服务则需要指定
                             ->pathPattern('/clusters/[ClusterId]/services') // 指定ROA风格路径规则
                             ->connectTimeout(0.1) // 设置连接超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->timeout(0.1) // 设置超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->debug(true) // 开启调试，CLI下会输出详细信息
                             ->withClusterId('123456') // 为路径中参数赋值，方法名：with + 参数
                             ->request(); // 发起请求并返回结果对象，请求需要放在设置的最后面

    // 链式调用发送 RPC 风格请求
    $rpcResult = AlibabaCloud::rpc()
                             ->client('client1') // 指定发送请求的客户端，不指定默认使用默认客户端
                             ->product('Cdn')
                             ->version('2014-11-11')
                             ->action('DescribeCdnService')
                             ->method('POST')
                             ->connectTimeout(0.1) // 设置连接超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->timeout(0.1) // 设置超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->debug(true) // 开启调试CLI下会输出详细信息
                             ->request();
        

    // 构造调用发送 RPC 风格请求
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

    // 设置的优先级
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
                                                // 所有参数也可以在 options 方法中设置或重新设置
                                                'query' => [
                                                    'Product'      => '我会覆盖构造函数的这个值',
                                                    'Version'      => '我是新增的值',
                                                ],
                                              ])
                                   ->options([
                                                // 可以多次调用 options 方法
                                                'query' => [
                                                    'Product' => '我会覆盖以前的值',
                                                    'Version' => '我会覆盖以前的值',
                                                    'Action'  => '我会覆盖以前的值',
                                                    'New'     => '我是新增的值',
                                                ],
                                              ])
                                   ->debug(false) // 最后调用的会覆盖前者的 true
                                   ->timeout(0.02) // 最后调用的会覆盖前者的 0.01
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

***
[← 客户端](Client-CN.md) | 请求[(English)](Request-EN.md) | [结果 →](Result-CN.md)

[SDK]: https://github.com/aliyun/openapi-sdk-php/blob/master/README-CN.md
[guzzle-docs]: https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html
