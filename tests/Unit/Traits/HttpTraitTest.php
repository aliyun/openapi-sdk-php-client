<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class HttpTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Client\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\ClientTrait
 */
class HttpTraitTest extends TestCase
{

    /**
     * @expectedException        \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Client 'default' not found
     * @throws                   ClientException
     */
    public static function testGetDefaultClient()
    {
        AlibabaCloud::flush();
        AlibabaCloud::getDefaultClient();
    }

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @throws ClientException
     */
    public function testVerify()
    {
        // Setup
        $client = AlibabaCloud::accessKeyClient('foo', 'bar')->asDefaultClient();

        // Assert
        self::assertFalse($client->options['verify']);

        // Test
        $client->verify(true);

        // Assert
        self::assertTrue($client->options['verify']);
    }
}
