<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\Requests\AssumeRole;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKey;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;

/**
 * Trait ClientTrait
 *
 * @package   AlibabaCloud\Client\Request\Traits
 *
 * @mixin     Request
 */
trait ClientTrait
{
    /**
     * Get the client based on the request's settings.
     *
     * @return Client
     * @throws ClientException
     */
    public function httpClient()
    {
        return AlibabaCloud::get($this->client);
    }

    /**
     * Return credentials directly if it is an AssumeRole or GenerateSessionAccessKey.
     *
     * @return AccessKeyCredential|BearerTokenCredential|CredentialsInterface|StsCredential
     * @throws ClientException
     * @throws ServerException
     */
    public function credential()
    {
        if ($this instanceof AssumeRole || $this instanceof GenerateSessionAccessKey) {
            return $this->httpClient()->getCredential();
        }

        return $this->httpClient()->getSessionCredential();
    }

    /**
     * Merged with the client's options, the same name will be overwritten.
     *
     * @throws ClientException
     */
    public function mergeOptionsIntoClient()
    {
        $this->options = \AlibabaCloud\Client\arrayMerge(
            [
                $this->httpClient()->options,
                $this->options,
            ]
        );
    }
}
