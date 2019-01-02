<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

/**
 * Class VirtualBearerTokenCredential
 *
 * @codeCoverageIgnore
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
 */
class VirtualBearerTokenCredential extends VirtualAccessKeyCredential
{

    /**
     * @return string
     */
    public static function noToken()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = bearer_token
EOT;
        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function client()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = bearer_token
bearer_token = bearer_token
region_id = cn-hangzhou
debug = true
delay = 3.2
timeout = 3.2
connect_timeout = 3.2
cert_file = /path/server.pem
cert_password = password
proxy = tcp://localhost:8125
proxy_http = tcp://localhost:8125
proxy_https = tcp://localhost:9124
proxy_no = .mit.edu,foo.com
EOT;
        return (new static($content))->url();
    }
}
