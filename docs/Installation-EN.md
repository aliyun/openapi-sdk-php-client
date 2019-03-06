[← Home](../README.md) | Installation[(中文)](Installation-CN.md) | [Client →](Client-EN.md)
***

# Installation
1. Download and install Composer（Windows user please download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe))
```bash
curl -sS https://getcomposer.org/installer | php
```

2. Execute the Composer command, install the newest and stable version of Alibaba Cloud Client for PHP
```bash
php -d memory_limit=-1 composer.phar require alibabacloud/client
```

3. Require the Composer auto-loading tool
```php
<?php

require __DIR__ . '/vendor/autoload.php'; 
```

***
[← Home](../README.md) | Installation[(中文)](Installation-CN.md) | [Client →](Client-EN.md)
