<?php

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Result\Result;

/**
 * Class DefaultAcsClient
 *
 * @package    AlibabaCloud
 *
 * @deprecated deprecated since version 2.0, Use AlibabaCloud instead.
 */
class DefaultAcsClient
{

    /**
     * @var string
     */
    public $randClientName;

    /**
     * DefaultAcsClient constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->randClientName = \uniqid('', true);
        $client->name($this->randClientName);
    }

    /**
     * @param Request|Result $request
     *
     * @return Result|string
     * @throws ClientException
     * @throws ServerException
     */
    public function getAcsResponse($request)
    {
        if ($request instanceof Result) {
            return $request;
        }

        return $request->client($this->randClientName)->request();
    }
}
