[← Debug](8-Debug-EN.md) | Log[(中文)](9-Log-CN.md) | [Test →](10-Test-EN.md)
***

# Log

## Set Logger

To start the logging function, pass in an object that implements the `LoggerInterface` interface, for example: `Monolog\Logger`.

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

## Log Format

### Default Format
```text
"{method} {uri} HTTP/{version}" {code} {cost} {hostname} {pid}
```

### Set Format
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::setLogFormat('{hostname} [{date_common_log}]');
```

### Variables

The following variable substitutions are supported:

| Variable |   Describe  |
|----------|-------------|
| {request}     | Full HTTP request message |
| {response}     | Full HTTP response message |
| {ts}     | ISO 8601 date in GMT |
| {date_iso_8601}     | ISO 8601 date in GMT |
| {date_common_log}     | Apache common log date using the configured timezone |
| {host}     | Host of the request |
| {method}     | Method of the request |
| {uri}     | URI of the request |
| {version}     | Protocol version |
| {target}     | Request target of the request (path + query + fragment) |
| {hostname}     | Hostname of the machine that sent the request |
| {code}     | Status code of the response (if available) |
| {phrase}     | Reason phrase of the response  (if available) |
| {error}     | Any error messages (if available) |
| {req_header_*}     | Replace `*` with the lowercased name of a request header to add to the message |
| {res_header_*}     | Replace `*` with the lowercased name of a response header to add to the message |
| {req_headers}     | Request headers |
| {res_headers}     | Response headers |
| {req_body}     | Request body |
| {res_body}     | Response body |
| {pid}     | PID |
| {cost}     | Cost Time |
| {start_time}     | Start Time |

***
[← Debug](8-Debug-EN.md) | Log[(中文)](9-Log-CN.md) | [Test →](10-Test-EN.md)
