<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Nlp;

use AlibabaCloud\Client\Request\RoaRequest;

/**
 * Class NlpRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Vpc
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
        $this->pathPattern('/nlp/api/wordsegment/general');
        $this->method('POST');
        $this->product('Nlp');
        $this->version('2018-04-08');
        $this->action('wordsegment');
        $this->options($options);
    }
}
