<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Nlp;

use AlibabaCloud\Client\Request\RoaRequest;

/**
 * Class NlpRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Vpc
 */
class NlpRequest extends RoaRequest
{

    /**
     * NlpRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->pathPattern('/nlp/api/wordsegment/[Domain]');
        $this->method('POST');
        $this->product('Nlp');
        $this->version('2018-04-08');
        $this->action('wordsegment');
        $this->options($options);
    }
}
