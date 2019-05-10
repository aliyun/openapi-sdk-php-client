<?php

namespace AlibabaCloud\Client\Result;

use Countable;
use Exception;
use ArrayAccess;
use IteratorAggregate;
use InvalidArgumentException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Traits\HasDataTrait;

/**
 * Result from Alibaba Cloud
 *
 * @property string|null RequestId
 *
 * @package   AlibabaCloud\Client\Result
 */
class Result extends Response implements ArrayAccess, IteratorAggregate, Countable
{
    use HasDataTrait;

    /**
     * Instance of the request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Result constructor.
     *
     * @param ResponseInterface $response
     * @param Request           $request
     */
    public function __construct(ResponseInterface $response, Request $request = null)
    {
        parent::__construct(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );

        $format = ($request instanceof Request) ? \strtoupper($request->format) : 'JSON';

        $content = $this->getBody()->getContents();

        switch ($format) {
            case 'JSON':
                $data = $this->jsonToArray($content);
                break;
            case 'XML':
                $data = $this->xmlToArray($content);
                break;
            case 'RAW':
                $data = $this->jsonToArray($content);
                break;
            default:
                $data = $this->jsonToArray($content);
        }

        if (empty($data)) {
            $data = [];
        }

        $this->dot($data);
        $this->request = $request;
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
        } catch (InvalidArgumentException $exception) {
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
        return (string)$this->getBody();
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
     * @deprecated
     */
    public function getResponse()
    {
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return 200 <= $this->getStatusCode()
               && 300 > $this->getStatusCode();
    }
}
