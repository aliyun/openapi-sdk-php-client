<?php

namespace AlibabaCloud\Client\Tests\Feature\Request;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Distinguish signature and credential errors
 *
 * @package   AlibabaCloud\Tests\Feature
 */
class DistinguishSignatureAndCredentialErrorsTest extends TestCase
{
    /**
     * @before
     * @throws ClientException
     */
    protected function initialize()
    {
        parent::setUp();
        AlibabaCloud::accessKeyClient(\getenv('ACCESS_KEY_ID'), 'bad')
            ->regionId('cn-shanghai')
            ->asDefaultClient();
    }

    /**
     * @throws ClientException
     */
    public function testInvalidAccessKeySecret()
    {
        
        try {
            AlibabaCloud::roa()
                ->pathPattern('/pop/2018-05-18/tokens')
                ->product('nls-cloud-meta')
                ->version('2018-05-18')
                ->method('POST')
                ->action('CreateToken')
                ->connectTimeout(25)
                ->timeout(30)
                ->request();
        } catch (ServerException $e) {
            self::assertEquals('Specified Access Key Secret is not valid.', $e->getErrorMessage());
        }
    }
}
