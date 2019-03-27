<?php

namespace AlibabaCloud\Client\Traits;

use Exception;
use Psr\Log\LoggerInterface;

/**
 * Trait LogTrait
 *
 * @package AlibabaCloud\Client\Traits
 */
trait LogTrait
{
    /**
     * @var LoggerInterface
     */
    private static $logger;

    /**
     * @var string
     */
    private static $logFormat;

    /**
     * @param LoggerInterface $logger
     *
     * @throws Exception
     */
    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public static function getLogger()
    {
        return self::$logger;
    }

    /**
     * Apache Common Log Format.
     *
     * @param string $formatter
     *
     * @link http://httpd.apache.org/docs/2.4/logs.html#common
     * @see  \GuzzleHttp\MessageFormatter
     */
    public static function setLogFormat($formatter)
    {
        self::$logFormat = $formatter;
    }

    /**
     * @return string
     */
    public static function getLogFormat()
    {
        return self::$logFormat
            ?: '"{method} {uri} HTTP/{version}" {code} {cost} {hostname} {pid}';
    }
}
