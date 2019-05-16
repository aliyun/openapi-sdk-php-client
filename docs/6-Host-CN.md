[← 区域](5-Region-CN.md) | 域名[(English)](6-Host-EN.md) | [SSL 验证 →](7-Verify-CN.md)
***

# 域名
在发送每个产品的具体请求前，Alibaba Cloud Client for PHP 会查找该产品在该区域的域名再发起请求，请参考 [Host 列表][endpoints]。

## 为请求指定域名
> 如果为请求指定了域名，则不启用寻址服务。建议指定的域名和服务器的区域相同，或者距离相近。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$request = AlibabaCloud::rpc()
                       ->product('Sts')
                       ->version('2015-04-01')
                       ->action('GenerateSessionAccessKey')
                       ->host('sts.ap-northeast-1.aliyuncs.com') // 指定域名
                       ->request();
```

## 为寻址服务增加可查找的域名
> 您还可以为某产品在某区域指定域名，寻址服务将不会发起请求，直接使用该域名。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// 为某产品增加在 cn-hangzhou 区域的域名
AlibabaCloud::addHost('product', 'product.cn-hangzhou.aliyuncs.com', 'cn-hangzhou');

// 为某产品增加全局域名，如果指定区域没有被指定域名，将使用全局域名
AlibabaCloud::addHost('product', 'product.aliyuncs.com');
```

***
[← 区域](5-Region-CN.md) | 域名[(English)](6-Host-EN.md) | [SSL 验证 →](7-Verify-CN.md)

[endpoints]: https://developer.aliyun.com/endpoints
