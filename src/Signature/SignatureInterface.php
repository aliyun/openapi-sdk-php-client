<?php

namespace AlibabaCloud\Client\Signature;

/**
 * Interface used to provide interchangeable strategies for requests.
 */
interface SignatureInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @param string $string
     * @param string $accessKeySecret
     *
     * @return string
     */
    public function sign($string, $accessKeySecret);

    /**
     * @return string
     */
    public function getType();
}
