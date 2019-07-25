<?php

namespace AlibabaCloud\Client\Tests\Unit\Filter;

use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Filter\CredentialFilter;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class CredentialFilterTest
 *
 * @package AlibabaCloud\Client\Tests\Unit\Filter
 */
class CredentialFilterTest extends TestCase
{
    /**
     * @dataProvider accessKey
     *
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $exceptionMessage
     */
    public function testAccessKey($accessKeyId, $accessKeySecret, $exceptionMessage)
    {
        try {
            CredentialFilter::AccessKey($accessKeyId, $accessKeySecret);
        } catch (ClientException $exception) {
            self::assertEquals($exceptionMessage, $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function accessKey()
    {
        return [
            [
                ' ',
                'AccessKeySecret',
                'AccessKey ID format is invalid',
            ],
            [
                'AccessKey',
                1,
                'AccessKey Secret must be a string',
            ],
            [
                'AccessKey',
                'AccessKey Secret ',
                'AccessKey Secret format is invalid',
            ],
        ];
    }
}
