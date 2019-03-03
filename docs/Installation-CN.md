[← 首页](../README-CN.md) | 安装[(English)](Installation-EN.md) | [客户端 →](Request-CN.md)
***

## 安装
1. 下载并安装 Composer（Windows 用户请下载并运行 [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)）
```bash
curl -sS https://getcomposer.org/installer | php
```

2. 执行 Composer 命令安装 Alibaba Cloud Client for PHP 的最新稳定版本
```bash
php -d memory_limit=-1 composer.phar require alibabacloud/client
```

3. 在代码中引入 Composer 自动加载工具
```php
<?php

require __DIR__ . '/vendor/autoload.php'; 
```

***
[← 首页](../README-CN.md) | 安装[(English)](Installation-EN.md) | [客户端 →](Request-CN.md)
