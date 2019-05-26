[← 调试](8-Debug.md) | 日志[(English)](../en/9-Log.md) | [测试 →](10-Test.md)
***

# 日志

## 设置 Logger

若要启动日志功能，请传入实现了 `LoggerInterface` 接口的对象，例如：`Monolog\Logger`。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logFile = __DIR__ . '/../../../log.log';
$logger  = new Logger('AlibabaCloud');
$logger->pushHandler(new StreamHandler($logFile));

AlibabaCloud::setLogger($logger);
```

## 日志格式化

### 默认格式
```text
"{method} {uri} HTTP/{version}" {code} {cost} {hostname} {pid}
```

### 设置格式
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::setLogFormat('{hostname} [{date_common_log}]');
```

### 变量

日志内容支持以下变量替换：

| 变量      |   描述       |
|----------|-------------|
| {request}     | 完整的HTTP请求消息 |
| {response}     | 完整的HTTP响应消息 |
| {ts}     | GMT中的 ISO 8601日期 |
| {date_iso_8601}     | GMT中的 ISO 8601日期 |
| {date_common_log}     | 使用配置的时区的Apache常用日志日期 |
| {host}     | 请求主机 |
| {method}     | 请求方法 |
| {uri}     | 请求的URI |
| {version}     | 协议版本 |
| {target}     | 请求目标 (path + query + fragment) |
| {hostname}     | 发送请求的计算机的主机名 |
| {code}     | 响应的状态代码（如果可用） |
| {phrase}     | 响应的原因短语（如果有） |
| {error}     | 任何错误消息（如果有） |
| {req_header_*}     | 将 `*` 替换为请求标头的小写名称以添加到消息中 |
| {res_header_*}     | 将 `*` 替换为响应头的小写名称以添加到消息中 |
| {req_headers}     | 请求头 |
| {res_headers}     | 响应头 |
| {req_body}     | 请求主体 |
| {res_body}     | 响应主体 |
| {pid}     | PID |
| {cost}     | 耗时 |
| {start_time}     | 开始时间 |

***
[← 调试](8-Debug.md) | 日志[(English)](../en/9-Log.md) | [测试 →](10-Test.md)
