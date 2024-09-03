<?php

namespace AlibabaCloud\Client\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class AlibabaCloudTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit
 *
 * @coversDefaultClass \AlibabaCloud\Client\AlibabaCloud
 */
class AlibabaCloudTest extends TestCase
{

    /**
     * @after
     */
    protected function finalize()
    {
        parent::tearDown();
        AlibabaCloud::flush();
    }

    public function testCallStatic()
    {
        $this->expectException(ClientException::class);
        $reg = '/May not yet support product/';
        if (method_exists($this, 'expectExceptionMessageMatches')) {
            $this->expectExceptionMessageMatches($reg);
        } elseif (method_exists($this, 'expectExceptionMessageRegExp')) {
            $this->expectExceptionMessageRegExp($reg);
        }
        AlibabaCloud::Ecs();
        
    }

}
