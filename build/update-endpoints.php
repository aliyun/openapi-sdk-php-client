<?php

use AlibabaCloud\Client\Config\Config;

// Setup autoloading for SDK and build classes.
require __DIR__ . '/../vendor/autoload.php';

$ossUrl = 'https://openapi-endpoints.oss-cn-hangzhou.aliyuncs.com/endpoints.json';
$json   = \file_get_contents($ossUrl);
$list   = \json_decode($json, true);

foreach ($list['endpoints'] as $endpoint) {
    Config::set(
        "endpoints.{$endpoint['service']}.{$endpoint['regionid']}",
        \strtolower($endpoint['endpoint'])
    );
}
