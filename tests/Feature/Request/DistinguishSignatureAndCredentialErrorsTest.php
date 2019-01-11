<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use PHPUnit\Framework\TestCase;

/**
 * Distinguish signature and credential errors
 *
 * @package   AlibabaCloud\Tests\Feature
 */
class DistinguishSignatureAndCredentialErrorsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        AlibabaCloud::accessKeyClient(\getenv('ACCESS_KEY_ID'), 'bad')
                    ->regionId('cn-shanghai')
                    ->asGlobalClient();
    }

    public function testInvalidAccessKeySecret()
    {
        try {
            AlibabaCloud::roaRequest()
                        ->pathPattern('/pop/2018-05-18/tokens')
                        ->product('nls-cloud-meta')
                        ->version('2018-05-18')
                        ->method('POST')
                        ->action('CreateToken')
                        ->request();
        } catch (ServerException $e) {
            self::assertEquals('Specified Access Key Secret is not valid.', $e->getErrorMessage());
            self::assertEquals('InvalidAccessKeySecret', $e->getErrorCode());
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error', $e->getErrorMessage());
        }
    }
}
