[← Region](5-Region-EN.md) | Host[(中文)](6-Host-CN.md) | [SSL Verify →](7-Verify-EN.md)
***

# Host
Before sending the detailed request for each product, Alibaba Cloud Client for PHP will find the Host of the product in the region, Please refer to [Host List][endpoints].

## Specify the Host for the request
> If a Host is specified for the request, the Location Service will not be enabled. It is recommended that the specified Host be the same as the server's region, or close.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$request = AlibabaCloud::rpc()
                       ->product('Sts')
                       ->version('2015-04-01')
                       ->action('GenerateSessionAccessKey')
                       ->host('sts.ap-northeast-1.aliyuncs.com') // Specify the Host
                       ->request();
```

## Add a searchable Host for the addressing service
> You can also set a Host in a region for a product. The addressing service will not make a request, but use this Host directly.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// Add a Host in the cn-hangzhou region for a product
AlibabaCloud::addHost('product_name', 'product_name.cn-hangzhou.aliyuncs.com', 'cn-hangzhou');

// Add a global Host for a product. If the specified Region is not specified Host, the global Host will be used.
AlibabaCloud::addHost('product_name', 'product_name.aliyuncs.com');
```

***
[← Region](5-Region-EN.md) | Host[(中文)](6-Host-CN.md) | [SSL Verify →](7-Verify-EN.md)
