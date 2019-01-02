<?php

namespace AlibabaCloud\Client\Http;

/**
 * Trait GuzzleTrait
 *
 * @package   AlibabaCloud\Client\Http
 */
trait GuzzleTrait
{

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string|null
     */
    public $regionId;

    /**
     * @param string $region
     *
     * @return $this
     */
    public function regionId($region)
    {
        $this->regionId = $region;
        return $this;
    }

    /**
     * @param int|float $timeout
     *
     * @return $this
     */
    public function timeout($timeout)
    {
        $this->options['timeout'] = $timeout;
        return $this;
    }

    /**
     * @param int|float $connectTimeout
     *
     * @return $this
     */
    public function connectTimeout($connectTimeout)
    {
        $this->options['connect_timeout'] = $connectTimeout;
        return $this;
    }

    /**
     * @param bool $debug
     *
     * @return $this
     */
    public function debug($debug)
    {
        $this->options['debug'] = $debug;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param array $cert
     *
     * @return $this
     */
    public function cert($cert)
    {
        $this->options['cert'] = $cert;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param array|string $proxy
     *
     * @return $this
     */
    public function proxy($proxy)
    {
        $this->options['proxy'] = $proxy;
        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function options(array $options)
    {
        if ($options !== []) {
            $this->options = \AlibabaCloud\Client\arrayMerge([$this->options, $options]);
        }
        return $this;
    }
}
