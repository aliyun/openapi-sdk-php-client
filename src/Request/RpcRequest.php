<?php

namespace AlibabaCloud\Client\Request;

use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
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
        $this->resolveQuery($credential);

        $this->options['query']['Signature'] = $this->signature(
            $this->options['query'],
            $credential->getAccessKeySecret()
        );

        if ($this->method === 'POST') {
            foreach ($this->options['query'] as $apiParamKey => $apiParamValue) {
                $this->options['form_params'][$apiParamKey] = $apiParamValue;
            }
            unset($this->options['query']);
        }
    }

    /**
     * Resolve request query.
     *
     * @param AccessKeyCredential|BearerTokenCredential|StsCredential $credential
     *
     * @throws ClientException
     */
    private function resolveQuery($credential)
    {
        if (isset($this->options['query'])) {
            foreach ($this->options['query'] as $key => $value) {
                $this->options['query'][$key] = self::booleanValueToString($value);
            }
        }
        $signature = $this->httpClient()->getSignature();
        if ($credential->getAccessKeyId()) {
            $this->options['query']['AccessKeyId'] = $credential->getAccessKeyId();
        }
        $this->options['query']['RegionId']         = $this->realRegionId();
        $this->options['query']['Format']           = $this->format;
        $this->options['query']['SignatureMethod']  = $signature->getMethod();
        $this->options['query']['SignatureVersion'] = $signature->getVersion();
        if ($signature->getType()) {
            $this->options['query']['SignatureType'] = $signature->getType();
        }
        $this->options['query']['SignatureNonce'] = md5(uniqid(mt_rand(), true));
        $this->options['query']['Timestamp']      = gmdate($this->dateTimeFormat);
        $this->options['query']['Action']         = $this->action;
        $this->options['query']['Version']        = $this->version;
        $this->resolveSecurityToken($credential);
        $this->resolveBearerToken($credential);
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
            if ($value) {
                return 'true';
            }

            return 'false';
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
     * @param array  $parameters
     * @param string $accessKeySecret
     *
     * @return mixed
     * @throws ClientException
     */
    private function signature($parameters, $accessKeySecret)
    {
        ksort($parameters);
        $canonicalizedQuery = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQuery .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }

        $this->stringToBeSigned = $this->method
                                  . '&%2F&'
                                  . $this->percentEncode(substr($canonicalizedQuery, 1));

        return $this->httpClient()
                    ->getSignature()
                    ->sign($this->stringToBeSigned, $accessKeySecret . '&');
    }

    /**
     * @param string $string
     *
     * @return null|string|string[]
     */
    protected function percentEncode($string)
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
