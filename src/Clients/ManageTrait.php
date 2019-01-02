<?php

namespace AlibabaCloud\Client\Clients;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\EcsRamRoleCredential;
use AlibabaCloud\Client\Credentials\Providers\EcsRamRoleProvider;
use AlibabaCloud\Client\Credentials\Providers\RamRoleArnProvider;
use AlibabaCloud\Client\Credentials\Providers\RsaKeyPairProvider;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Credentials\StsCredential;

/**
 * Trait ManageTrait.
 *
 * @package   AlibabaCloud\Client\Clients
 *
 * @mixin     Client
 */
trait ManageTrait
{

    /**
     * @param int $timeout
     *
     * @return AccessKeyCredential|CredentialsInterface|StsCredential
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function getSessionCredential($timeout = \ALIBABA_CLOUD_TIMEOUT)
    {
        switch (\get_class($this->credential)) {
            case EcsRamRoleCredential::class:
                return (new EcsRamRoleProvider($this))->get();
            case RamRoleArnCredential::class:
                return (new RamRoleArnProvider($this))->get($timeout);
            case RsaKeyPairCredential::class:
                return (new RsaKeyPairProvider($this))->get($timeout);
            default:
                return $this->credential;
        }
    }

    /**
     * Naming clients.
     *
     * @param string $clientName
     *
     * @return static
     */
    public function name($clientName)
    {
        return AlibabaCloud::set($clientName, $this);
    }

    /**
     * Set the current client as the global client.
     *
     * @return static
     */
    public function asGlobalClient()
    {
        return $this->name(\ALIBABA_CLOUD_GLOBAL_CLIENT);
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        if (isset($this->options['debug'])) {
            return $this->options['debug'] === true && PHP_SAPI === 'cli';
        }

        return false;
    }
}
