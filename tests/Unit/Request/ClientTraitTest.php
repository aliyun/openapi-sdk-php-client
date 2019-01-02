<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\RamRoleArnCredential;
use AlibabaCloud\Client\Credentials\Requests\AssumeRole;
use AlibabaCloud\Client\Credentials\Requests\GenerateSessionAccessKey;
use AlibabaCloud\Client\Credentials\RsaKeyPairCredential;
use AlibabaCloud\Client\Tests\Mock\Services\Cdn\DescribeCdnServiceRequest;
use AlibabaCloud\Client\Tests\Unit\Credentials\Ini\VirtualRsaKeyPairCredential;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTraitTest
 *
 * @package            AlibabaCloud\Client\Tests\Unit\Request
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\Request
 */
class ClientTraitTest extends TestCase
{

    /**
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function testMergeOptionsIntoClient()
    {
        // Setup
        $clientName = __METHOD__;
        $expected   = 'i \'m request';

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->options(
                        [
                            'headers' => [
                                'client' => 'client',
                            ],
                        ]
                    )
                    ->name($clientName);

        $request = (new DescribeCdnServiceRequest())->client($clientName)
                                                    ->options(['request1' => 'request'])
                                                    ->options(['request2' => 'request2'])
                                                    ->options(
                                                        [
                                                            'headers' => [
                                                                'client' => $expected,
                                                            ],
                                                        ]
                                                    );
        $request->mergeOptionsIntoClient();

        // Assert
        $this->assertEquals($expected, $request->options['headers']['client']);
    }

    public function testCredential()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new DescribeCdnServiceRequest())->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }

    public function testCredentialOnAssumeRole()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new AssumeRole(
            new RamRoleArnCredential(
                'key',
                'secret',
                'arn',
                'name'
            )
        ))->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }

    public function testCredentialOnGenerateSessionAccessKey()
    {
        // Setup
        $clientName = __METHOD__;

        // Test
        AlibabaCloud::accessKeyClient('key', 'secret')
                    ->asGlobalClient()
                    ->regionId('cn-hangzhou')
                    ->name($clientName);

        $request = (new GenerateSessionAccessKey(
            new RsaKeyPairCredential(
                'key',
                VirtualRsaKeyPairCredential::ok()
            )
        ))->client($clientName);

        // Assert
        self::assertEquals('key', $request->credential()->getAccessKeyId());
        self::assertEquals('secret', $request->credential()->getAccessKeySecret());
    }
}
