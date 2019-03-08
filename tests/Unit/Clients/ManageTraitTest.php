<?php

namespace AlibabaCloud\Client\Tests\Unit\Clients;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ManageTraitTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Clients
 */
class ManageTraitTest extends TestCase
{

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testRsaKeyPairClient()
    {
        AlibabaCloud::mockResponse(
            200,
            [],
            [
                'RequestId'        => 'DDDDD-D2BB-4E66-B4BD-9349471769E2',
                'SessionAccessKey' => [
                    'SessionAccessKeyId'     => 'TMPSK.abcd',
                    'Expiration'             => '2019-03-08T14:03:34.550Z',
                    'SessionAccessKeySecret' => 'eIK-ASD891281212.',
                ],
            ]
        );
        $client     = AlibabaCloud::rsaKeyPairClient(
            'id',
            VirtualRsaKeyPairCredential::privateKeyFileUrl()
        );
        $credential = $client->getSessionCredential();
        self::assertEquals('TMPSK.abcd', $credential->getAccessKeyId());
        AlibabaCloud::cancelMock();
    }
}
