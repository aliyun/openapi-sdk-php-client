[← Debug](8-Debug-EN.md) | Test[(中文)](9-Test-CN.md) | [Home →](../README.md)
***

# Test

## Mock Response
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


## Mock Exception
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


## Cancel Mock
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::cancelMock();
```

***
[← Debug](8-Debug-EN.md) | Test[(中文)](9-Test-CN.md) | [Home →](../README.md)
