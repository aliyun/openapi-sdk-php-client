[← Host](6-Host.md) | SSL Verify[(中文)](../zh/7-Verify.md) | [Debug →](8-Debug.md)
***

# SSL Verify

## Summary
Describes the SSL certificate verification behavior of a request.
- Set `false` to disable certificate validation, (This is not safe, please set certificates! )
- Set to `true` to enable SSL certificate verification and use the default CA bundle provided by operating system.
- Set to a string to provide the path to a CA bundle to enable verification using a custom certificate.

## Default
- `false` 

## Setting
### Setting on Request
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;


$request = AlibabaCloud::rpc()
                       ->product('Sts')
                       ->version('2015-04-01')
                       ->action('GenerateSessionAccessKey')
                       ->host('sts.ap-northeast-1.aliyuncs.com');

// Use the system's CA bundle
$request->verify(true);

// Use a custom SSL certificate on disk
$request->verify(['verify' => '/path/to/cert.pem']);

// Use a custom SSL certificate with password on disk
$request->verify(['verify' => ['/path/to/cert.pem','password']]);
```

### Setting on Client
> When the request is not set, the client settings are used.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// Use the system's CA bundle
AlibabaCloud::accessKeyClient('foo', 'bar')
            ->verify(true)
            ->asDefaultClient();

// Use a custom SSL certificate on disk
AlibabaCloud::accessKeyClient('foo', 'bar')
            ->verify(['verify' => '/path/to/cert.pem'])
            ->asDefaultClient();

// Use a custom SSL certificate with password on disk
AlibabaCloud::accessKeyClient('foo', 'bar')
            ->verify(['/path/to/cert.pem','password'])
            ->asDefaultClient();
```

## Reference
- [Guzzle Request Options - verify](http://docs.guzzlephp.org/en/stable/request-options.html#verify)


***
[← Host](6-Host.md) | SSL Verify[(中文)](../zh/7-Verify.md) | [Debug →](8-Debug.md)
