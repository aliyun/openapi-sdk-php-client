<?php

namespace AlibabaCloud\Client\Tests\Mock\Services\Rds;

use AlibabaCloud\Client\Request\RpcRequest;

/**
 * Class DeleteDatabaseRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\Rds
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2019 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
        $this->locationServiceCode  = 'rds';
        $this->locationEndpointType = 'openAPI';
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
    public function setResourceOwnerId($resourceOwnerId)
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
    public function setDBName($dBName)
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
    public function setResourceOwnerAccount($resourceOwnerAccount)
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
    public function setOwnerAccount($ownerAccount)
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
    public function setDBInstanceId($dBInstanceId)
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
    public function setOwnerId($ownerId)
    {
        $this->ownerId                     = $ownerId;
        $this->options['query']['OwnerId'] = $ownerId;
    }
}
