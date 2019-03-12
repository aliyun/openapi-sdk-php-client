[← 调试](8-Debug-CN.md) | 测试[(English)](9-Test-EN.md) | [首页 →](../README-CN.md)
***

# 测试

## Mock 响应
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;

$header = ['X-Foo' => 'Bar'];
$body   = [
    'Code'    => 'code',
    'Message' => 'message',
];

AlibabaCloud::mockResponse(200, $header, $body);
AlibabaCloud::mockResponse(500, $header, $body);

$result = AlibabaCloud::rpc()
                      ->product('ecs')
                      ->regionId('cn-hangzhou')
                      ->request();

print_r($result->toArray());

try {
    AlibabaCloud::rpc()
                ->product('ecs')
                ->regionId('cn-hangzhou')
                ->request();
} catch (ServerException $e) {
    print_r($e->getErrorMessage());
    print_r($e->getResult()->toArray());
}
```


## Mock 异常
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

AlibabaCloud::mockRequestException('Error', new Request('GET', 'test'));

try {
    AlibabaCloud::rpc()->product('ecs')->regionId('cn-hangzhou')->request();
} catch (ClientException $e) {
    // Error
    echo $e->getErrorMessage();
}
```


## 取消 Mock
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::cancelMock();
```


***
[← 调试](8-Debug-CN.md) | 测试[(English)](9-Test-EN.md) | [首页 →](../README-CN.md)
