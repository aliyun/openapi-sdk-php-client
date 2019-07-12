[← Result](/docs/en-US/4-Result.md) | Region[(中文)](/docs/zh-CN/5-Region.md) | [Host →](/docs/en-US/6-Host.md)
***

# Region
Each request carries an region called `regionId`. Since most of the requested regions are the same, it is not necessary to set the region for each request, Please refer to [Regions and Zones][regions].

## Specify the Region for the Request
> If you specify an Region separately for the request, the client Region or default Region will not be used.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$result = AlibabaCloud::rpc()
                      ->client('client1') // Specify client, if not, the default client is used by default
                      ->regionId('cn-hangzhou') // Specify the requested Region as cn-hangzhou
                      ->product('Cdn')
                      ->version('2014-11-11')
                      ->action('DescribeCdnService')
                      ->method('POST')
                      ->request();
```

## Specify the Region for the Client
> You can also specify an Region when you create a client, and if the client's request is not specified Region, use the client's Region.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')
            ->regionId('cn-hangzhou') // Specify the client Region as cn-hangzhou
            ->name('client1');
```

## Set the Default Region
> If both the Request and Request's client do not have an Region, the default Region will be used.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// Set the default Region to cn-hangzhou
AlibabaCloud::setDefaultRegionId('cn-hangzhou');

// Get the default Region
AlibabaCloud::getDefaultRegionId();
```

***
[← Result](/docs/en-US/4-Result.md) | Region[(中文)](/docs/zh-CN/5-Region.md) | [Host →](/docs/en-US/6-Host.md)

[regions]: https://www.alibabacloud.com/help/doc-detail/40654.html
