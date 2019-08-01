[← 域名](/docs/zh-CN/6-Host.md) | SSL 验证[(English)](/docs/en-US/7-Verify.md) | [调试 →](/docs/zh-CN/8-Debug.md)
***

# SSL 验证

## 摘要
请求时验证SSL证书行为。
- 设置成 `false` 禁用证书验证，(这是不安全的，请设置证书！)。
- 设置成 `true` 启用SSL证书验证，默认使用操作系统提供的CA包。
- 设置成字符串启用验证，并使用该字符串作为自定义证书CA包的路径。

## 默认值
- `false` 

## 请求设置
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$request = AlibabaCloud::rpc()
                       ->product('Sts')
                       ->version('2015-04-01')
                       ->action('GenerateSessionAccessKey')
                       ->host('sts.ap-northeast-1.aliyuncs.com');

// 在操作系统中寻找
$request->verify(true);

// 使用指定的文件
$request->verify(['verify' => '/path/to/cert.pem']);

// 使用指定的文件和密码
$request->verify(['verify' => ['/path/to/cert.pem','password']]);
```

## 客户端设置
> 当请求没有设置时，将使用客户端设置。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// 在操作系统中寻找
AlibabaCloud::accessKeyClient('foo', 'bar')
            ->verify(true)
            ->asDefaultClient();

// 使用指定的文件
AlibabaCloud::accessKeyClient('foo', 'bar')
            ->verify(['verify' => '/path/to/cert.pem'])
            ->asDefaultClient();

// 使用指定的文件和密码
AlibabaCloud::accessKeyClient('foo', 'bar')
            ->verify(['/path/to/cert.pem','password'])
            ->asDefaultClient();
```

## 参考
- [Guzzle 请求选项 - verify](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html#verify)


***
[← 域名](/docs/zh-CN/6-Host.md) | SSL 验证[(English)](/docs/en-US/7-Verify.md) | [调试 →](/docs/zh-CN/8-Debug.md)
