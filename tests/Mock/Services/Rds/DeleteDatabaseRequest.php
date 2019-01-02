<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Rds;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DeleteDatabaseRequest
 *
 * @property mixed|string|null object
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Rds
 */
class DeleteDatabaseRequest extends RpcRequest
{

    /**
     * DeleteDatabaseRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->method('POST');
        $this->product('Rds');
        $this->version('2014-08-15');
        $this->action('DeleteDatabase');
        $this->serviceCode  = 'rds';
        $this->endpointType = 'openAPI';
        $this->options($options);
    }

    /**
     * @var
     */
    private $resourceOwnerId;

    /**
     * @var
     */
    private $dBName;

    /**
     * @var
     */
    private $resourceOwnerAccount;

    /**
     * @var
     */
    private $ownerAccount;

    /**
     * @var
     */
    private $dBInstanceId;

    /**
     * @var
     */
    private $ownerId;

    /**
     * @return mixed
     */
    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    /**
     * @param $resourceOwnerId
     */
    public function withResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId                     = $resourceOwnerId;
        $this->options['query']['ResourceOwnerId'] = $resourceOwnerId;
    }

    /**
     * @return mixed
     */
    public function getDBName()
    {
        return $this->dBName;
    }

    /**
     * @param $dBName
     */
    public function withDBName($dBName)
    {
        $this->dBName                     = $dBName;
        $this->options['query']['DBName'] = $dBName;
    }

    /**
     * @return mixed
     */
    public function getResourceOwnerAccount()
    {
        return $this->resourceOwnerAccount;
    }

    /**
     * @param $resourceOwnerAccount
     */
    public function withResourceOwnerAccount($resourceOwnerAccount)
    {
        $this->resourceOwnerAccount                     = $resourceOwnerAccount;
        $this->options['query']['ResourceOwnerAccount'] = $resourceOwnerAccount;
    }

    /**
     * @return mixed
     */
    public function getOwnerAccount()
    {
        return $this->ownerAccount;
    }

    /**
     * @param $ownerAccount
     */
    public function withOwnerAccount($ownerAccount)
    {
        $this->ownerAccount                     = $ownerAccount;
        $this->options['query']['OwnerAccount'] = $ownerAccount;
    }

    /**
     * @return mixed
     */
    public function getDBInstanceId()
    {
        return $this->dBInstanceId;
    }

    /**
     * @param $dBInstanceId
     */
    public function withDBInstanceId($dBInstanceId)
    {
        $this->dBInstanceId                     = $dBInstanceId;
        $this->options['query']['DBInstanceId'] = $dBInstanceId;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param $ownerId
     */
    public function withOwnerId($ownerId)
    {
        $this->ownerId                     = $ownerId;
        $this->options['query']['OwnerId'] = $ownerId;
    }
}
