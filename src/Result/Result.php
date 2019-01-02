<?php

namespace AlibabaCloud\Client\Result;

use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Traits\ArrayAccessTrait;
use AlibabaCloud\Client\Traits\FormatTrait;
use AlibabaCloud\Client\Traits\HasDataTrait;
use AlibabaCloud\Client\Traits\ObjectAccessTrait;
use GuzzleHttp\Psr7\Response;

/**
 * Result from Alibaba Cloud
 *
 * @property string|null RequestId
 *
 * @package   AlibabaCloud\Client\Result
 */
class Result implements \ArrayAccess, \IteratorAggregate, \Countable
{
    use ArrayAccessTrait;
    use HasDataTrait;
    use FormatTrait;
    use ObjectAccessTrait;

    /**
     * Instance of the response.
     *
     * @var Response
     */
    protected $response;

    /**
     * Instance of the request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Array data of the response.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Result constructor.
     *
     * @param Response $response
     * @param Request  $request
     */
    public function __construct(Response $response, Request $request = null)
    {
        $format = ($request instanceof Request) ? \strtoupper($request->format) : 'JSON';

        switch ($format) {
            case 'JSON':
                $this->data = $this->jsonToArray($response->getBody()->getContents());
                break;
            case 'XML':
                $this->data = $this->xmlToArray($response->getBody()->getContents());
                break;
            case 'RAW':
                $this->data = $this->jsonToArray($response->getBody()->getContents());
                break;
            default:
                $this->data = $this->jsonToArray($response->getBody()->getContents());
        }

        if (empty($this->data)) {
            $this->data = [];
        }
        $this->response = $response;
        $this->request  = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return 200 <= $this->response->getStatusCode()
               && 300 > $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->response->getBody()->getContents();
    }
}
