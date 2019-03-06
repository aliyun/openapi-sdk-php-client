[← 结果](Result-CN.md) | 区域[(English)](Region-EN.md) | [域名 →](Host-CN.md)
***

# 区域
每个请求都会携带区域 `regionId`，由于大部分请求的区域相同，没有必要为每个请求设置区域，请参考 [Region 列表][endpoints]。

## 为请求指定区域
> 如果为请求单独指定区域，将不使用客户端区域或默认区域。
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$result = AlibabaCloud::rpc()
                      ->client('client1') // 指定发送请求的客户端，不指定默认使用默认客户端
                      ->regionId('cn-hangzhou') // 指定请求的区域为 cn-hangzhou
                      ->product('Cdn')
                      ->version('2014-11-11')
                      ->action('DescribeCdnService')
                      ->method('POST')
                      ->request();
```

## 为客户端指定区域
> 您还可以在创建客户端时指定区域，如果使用该客户端的请求没有被指定区域，则使用该客户端的区域。
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')
            ->regionId('cn-hangzhou') // 指定客户端区域为 cn-hangzhou
            ->name('client1');
```

## 设定默认区域
> 如果请求和请求的客户端都没有设置区域，将使用默认区域。
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// 设置默认区域为 cn-hangzhou
AlibabaCloud::setDefaultRegionId('cn-hangzhou');

// 获取默认区域
AlibabaCloud::getDefaultRegionId();
```

***
[← 结果](Result-CN.md) | 区域[(English)](Region-EN.md) | [域名 →](Host-CN.md)
