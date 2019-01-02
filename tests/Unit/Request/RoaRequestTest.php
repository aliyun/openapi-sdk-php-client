<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClusterServicesRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RoaRequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\RoaRequest
 */
class RoaRequestTest extends TestCase
{

    /**
     * @throws \ReflectionException
     */
    public function testContentMD5()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        $request->withClusterId(\time());
        $request->options(
            [
                'form_params' => [
                    'test' => 'test',
                ],
            ]
        );
        $expected = 'govO+HY8G8YW4loGvkuQ/w==';

        // Test
        $method = new \ReflectionMethod(DescribeClusterServicesRequest::class, 'contentMD5');
        $method->setAccessible(true);
        $actual = $method->invoke($request);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @throws \ReflectionException
     */
    public function testAssignPathParametersWithMagicMethod()
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $expected  = '/clusters/' . $clusterId . '/services';

        // Test
        $request->withClusterId($clusterId);
        $method = new \ReflectionMethod(
            DescribeClusterServicesRequest::class,
            'assignPathParameters'
        );
        $method->setAccessible(true);
        $actual = $method->invoke($request);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @throws \ReflectionException
     */
    public function testAssignPathParametersWithOption()
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $expected  = '/clusters/' . $clusterId . '/services';

        // Test
        $request->pathParameter('ClusterId', $clusterId);
        $method = new \ReflectionMethod(
            DescribeClusterServicesRequest::class,
            'assignPathParameters'
        );
        $method->setAccessible(true);
        $actual = $method->invoke($request);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @throws \ReflectionException
     * @throws ClientException
     */
    public function testConstructAcsHeader()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        $request->withClusterId(\time());
        $request->regionId('cn-hangzhou');
        $clusterId  = \time();
        $credential = new AccessKeyCredential('key', 'secret');
        $request->resolveParameters($credential);
        $expected = "x-acs-region-id:cn-hangzhou\n" .
                    "x-acs-signature-method:HMAC-SHA1\n" .
                    "x-acs-signature-version:1.0\n" .
                    "x-acs-version:2015-12-15\n";

        // Test
        $request->pathParameter('ClusterId', $clusterId);
        $method = new \ReflectionMethod(
            DescribeClusterServicesRequest::class,
            'constructAcsHeader'
        );
        $method->setAccessible(true);
        $actual = $method->invoke($request);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @param array  $query
     * @param string $expected
     *
     * @dataProvider buildQueryString
     * @throws ClientException
     */
    public function testBuildQueryString(array $query, $expected)
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->regionId('cn-hangzhou')
                    ->asGlobalClient();

        // Test
        $request->options(['query' => $query]);
        $request->resolveParameters(AlibabaCloud::getGlobalClient()->getCredential());

        // Assert
        self::assertEquals($expected, $request->queryString());
    }

    /**
     * @return array
     */
    public function buildQueryString()
    {
        return [
            [
                [
                    'a' => 'a',
                    'b' => 'b',
                ],
                'Version=2015-12-15&a=a&b=b',
            ],
            [
                [
                    'b' => 'b',
                    'c' => 'c',
                ],
                'Version=2015-12-15&b=b&c=c',
            ],
        ];
    }

    /**
     * @param $format
     * @param $expected
     *
     * @throws       \ReflectionException
     * @dataProvider formatToAccept
     */
    public function testFormatToAccept($format, $expected)
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();

        // Test
        $request->pathParameter('ClusterId', $clusterId);
        $method = new \ReflectionMethod(
            DescribeClusterServicesRequest::class,
            'formatToAccept'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, [$format]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function formatToAccept()
    {
        return [
            ['JSON', 'application/json',],
            ['XML', 'application/xml',],
            ['RAW', 'application/octet-stream',],
            ['NON', 'application/octet-stream',],
        ];
    }

    /**
     * @param $key
     * @param $value
     *
     * @dataProvider pathParameter
     */
    public function testPathParameter($key, $value)
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->pathParameter($key, $value);

        // Assert
        self::assertEquals($value, $request->pathParameters[$key]);
    }

    /**
     * @return array
     */
    public function pathParameter()
    {
        return [
            ['1', '1'],
            ['2', '2'],
            ['3', '3'],
            ['4', '4'],
        ];
    }

    /**
     * @param $pattern
     *
     * @dataProvider pathPattern
     */
    public function testPathPattern($pattern)
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->pathPattern($pattern);

        // Assert
        self::assertEquals($pattern, $request->pathPattern);
    }

    /**
     * @return array
     */
    public function pathPattern()
    {
        return [
            ['1'],
            ['2'],
            ['3'],
            ['4'],
        ];
    }

    /**
     * @param $version
     *
     * @dataProvider version
     * @throws ClientException
     */
    public function testVersion($version)
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        AlibabaCloud::accessKeyClient('foo', 'bar')
                    ->regionId('cn-hangzhou')
                    ->asGlobalClient();

        // Test
        $request->version($version);
        $request->resolveParameters(AlibabaCloud::getGlobalClient()->getCredential());

        // Assert
        self::assertEquals($version, $request->version);
        self::assertEquals($version, $request->options['query']['Version']);
        self::assertEquals($version, $request->options['headers']['x-acs-version']);
    }

    /**
     * @return array
     */
    public function version()
    {
        return [
            ['1'],
            ['2'],
            ['3'],
            ['4'],
        ];
    }

    /**
     * @param $setName
     * @param $getName
     * @param $setValue
     *
     * @param $getValue
     *
     * @dataProvider call
     */
    public function testCall($setName, $getName, $setValue, $getValue)
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->$setName($setValue);

        // Assert
        self::assertEquals($getValue, $request->$getName());
    }

    /**
     * @return array
     */
    public function call()
    {
        return [
            ['withVirtualParameter', 'getVirtualParameter', 'value', 'value'],
            ['withVirtualParameter', 'getNone', 'value', null],
        ];
    }

    /**
     * @return array
     */
    public function resolveQuery()
    {
        return [
            [
                new StsCredential('foo', 'bar', 'token'),
            ],
            [
                new BearerTokenCredential('token'),
            ],
        ];
    }

    /**
     * @param CredentialsInterface $credential
     *
     * @throws       ClientException
     * @dataProvider resolveQuery
     */
    public function testResolveParameters($credential)
    {
        // Setup
        AlibabaCloud::bearerTokenClient('token')->name('token');
        $clusterId = time();
        $request   = new  DescribeClusterServicesRequest();
        $request->withClusterId($clusterId);
        $request->client('token');
        $request->options(
            [
                'form_params' => [
                    'test' => 'test',
                ],
            ]
        );
        $request->regionId('cn-hangzhou');
        $request->method('post');
        $request->options(
            [
                'query' => [
                    'A' => 'A',
                ],
            ]
        );
        $expected = "http://localhost/clusters/{$clusterId}/services?A=A&Version=2015-12-15";

        // Test
        $request->resolveParameters($credential);

        // Assert
        self::assertEquals($expected, (string)$request->uri);
    }
}
