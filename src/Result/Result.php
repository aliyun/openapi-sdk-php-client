<?php

namespace AlibabaCloud\Client\Result;

use Countable;
use Exception;
use ArrayAccess;
use IteratorAggregate;
use GuzzleHttp\Psr7\Response;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Traits\HasDataTrait;

/**
 * Result from Alibaba Cloud
 *
 * @property string|null RequestId
 *
 * @package   AlibabaCloud\Client\Result
 */
class Result implements ArrayAccess, IteratorAggregate, Countable
{
    use HasDataTrait;

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
                $data = $this->jsonToArray($response->getBody()->getContents());
                break;
            case 'XML':
                $data = $this->xmlToArray($response->getBody()->getContents());
                break;
            case 'RAW':
                $data = $this->jsonToArray($response->getBody()->getContents());
                break;
            default:
                $data = $this->jsonToArray($response->getBody()->getContents());
        }

        if (empty($data)) {
            $data = [];
        }

        $this->dot($data);
        $this->response = $response;
        $this->request  = $request;
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private function jsonToArray($response)
    {
        try {
            return \GuzzleHttp\json_decode($response, true);
        } catch (\InvalidArgumentException $e) {
            return [];
        }
    }

    /**
     * @param string $string
     *
     * @return array
     */
    private function xmlToArray($string)
    {
        try {
            return json_decode(json_encode(simplexml_load_string($string)), true);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->response->getBody();
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
}
