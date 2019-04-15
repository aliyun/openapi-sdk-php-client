<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use Exception;
use Ramsey\Uuid\Uuid;
use RuntimeException;

/**
 * RESTful RPC Request.
 *
 * @package   AlibabaCloud\Client\Request
 */
class RpcRequest extends Request
{

    /**
     * @var string
     */
    private $dateTimeFormat = 'Y-m-d\TH:i:s\Z';

    /**
     * Resolve request parameter.
     *
     * @param AccessKeyCredential|BearerTokenCredential|StsCredential $credential
     *
     * @throws ClientException
     */
    public function resolveParameters($credential)
    {
        $this->resolveCommonParameters($credential);
        $this->options['query']['Signature'] = $this->signature($credential->getAccessKeySecret());
        $this->repositionParameters();
    }

    /**
     * Resolve Common Parameters.
     *
     * @param AccessKeyCredential|BearerTokenCredential|StsCredential $credential
     *
     * @throws ClientException
     * @throws Exception
     */
    private function resolveCommonParameters($credential)
    {
        if (isset($this->options['query'])) {
            foreach ($this->options['query'] as $key => $value) {
                $this->options['query'][$key] = self::booleanValueToString($value);
            }
        }

        $signature = $this->httpClient()->getSignature();
        if (!isset($this->options['query']['AccessKeyId']) && $credential->getAccessKeyId()) {
            $this->options['query']['AccessKeyId'] = $credential->getAccessKeyId();
        }

        if (!isset($this->options['query']['RegionId'])) {
            $this->options['query']['RegionId'] = $this->realRegionId();
        }

        if (!isset($this->options['query']['Format'])) {
            $this->options['query']['Format'] = $this->format;
        }

        if (!isset($this->options['query']['SignatureMethod'])) {
            $this->options['query']['SignatureMethod'] = $signature->getMethod();
        }

        if (!isset($this->options['query']['SignatureVersion'])) {
            $this->options['query']['SignatureVersion'] = $signature->getVersion();
        }

        if (!isset($this->options['query']['SignatureType']) && $signature->getType()) {
            $this->options['query']['SignatureType'] = $signature->getType();
        }

        if (!isset($this->options['query']['SignatureNonce'])) {
            $this->options['query']['SignatureNonce'] = Uuid::uuid1()->toString();
        }

        if (!isset($this->options['query']['Timestamp'])) {
            $this->options['query']['Timestamp'] = gmdate($this->dateTimeFormat);
        }

        if (!isset($this->options['query']['Action'])) {
            $this->options['query']['Action'] = $this->action;
        }

        if (!isset($this->options['query']['Version'])) {
            $this->options['query']['Version'] = $this->version;
        }

        $this->resolveSecurityToken($credential);
        $this->resolveBearerToken($credential);
    }

    /**
     * Adjust parameter position
     */
    private function repositionParameters()
    {
        if ($this->method === 'POST' || $this->method === 'PUT') {
            foreach ($this->options['query'] as $apiParamKey => $apiParamValue) {
                $this->options['form_params'][$apiParamKey] = $apiParamValue;
            }
            unset($this->options['query']);
        }
    }

    /**
     * Convert a Boolean value to a string.
     *
     * @param bool|string $value
     *
     * @return string
     */
    private static function booleanValueToString($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return $value;
    }

    /**
     * @param CredentialsInterface $credential
     */
    private function resolveSecurityToken(CredentialsInterface $credential)
    {
        if ($credential instanceof StsCredential && $credential->getSecurityToken()) {
            $this->options['query']['SecurityToken'] = $credential->getSecurityToken();
        }
    }

    /**
     * @param CredentialsInterface $credential
     */
    private function resolveBearerToken(CredentialsInterface $credential)
    {
        if ($credential instanceof BearerTokenCredential) {
            $this->options['query']['BearerToken'] = $credential->getBearerToken();
        }
    }

    /**
     * Sign the parameters.
     *
     * @param string $accessKeySecret
     *
     * @return mixed
     * @throws ClientException
     */
    private function signature($accessKeySecret)
    {
        return $this->httpClient()
                    ->getSignature()
                    ->sign(
                        $this->stringToSign(),
                        $accessKeySecret . '&'
                    );
    }

    /**
     * @return string
     */
    public function stringToSign()
    {
        $query       = isset($this->options['query']) ? $this->options['query'] : [];
        $form_params = isset($this->options['form_params']) ? $this->options['form_params'] : [];
        $parameters  = \AlibabaCloud\Client\arrayMerge([$query, $form_params]);
        ksort($parameters);
        $canonicalizedQuery = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQuery .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }

        return $this->method . '&%2F&' . $this->percentEncode(substr($canonicalizedQuery, 1));
    }

    /**
     * @param string $string
     *
     * @return null|string|string[]
     */
    private function percentEncode($string)
    {
        $result = urlencode($string);
        $result = str_replace(['+', '*'], ['%20', '%2A'], $result);
        $result = preg_replace('/%7E/', '~', $result);

        return $result;
    }

    /**
     * Magic method for set or get request parameters.
     *
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (\strpos($name, 'get') === 0) {
            $parameterName = $this->propertyNameByMethodName($name);

            return $this->__get($parameterName);
        }

        if (\strpos($name, 'with') === 0) {
            $parameterName = $this->propertyNameByMethodName($name, 4);
            $this->__set($parameterName, $arguments[0]);
            $this->options['query'][$parameterName] = $arguments[0];

            return $this;
        }

        if (\strpos($name, 'set') === 0) {
            $parameterName = $this->propertyNameByMethodName($name);
            $withMethod    = "with$parameterName";

            return $this->$withMethod($arguments[0]);
        }

        throw new RuntimeException('Call to undefined method ' . __CLASS__ . '::' . $name . '()');
    }
}
