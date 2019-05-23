<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use Stringy\Stringy;
use ReflectionObject;
use RuntimeException;
use ReflectionMethod;
use ReflectionException;
use GuzzleHttp\Psr7\Request;
use AlibabaCloud\Client\Encode;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Accept;
use AlibabaCloud\Client\Support\Path;
use AlibabaCloud\Client\Support\Sign;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RoaRequest;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Tests\Mock\Services\CS\DescribeClusterServicesRequest;

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
     * @throws ReflectionException
     * @throws ClientException
     */
    public function testAssignPathParametersWithMagicMethod()
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $expected  = '/clusters/' . $clusterId . '/services';

        // Test
        $request->withClusterId($clusterId);
        $method = new ReflectionMethod(
            Path::class,
            'assign'
        );
        $actual = $method->invokeArgs($request, [$request->pathPattern, $request->pathParameters]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @throws ReflectionException
     * @throws ClientException
     */
    public function testAssignPathParametersWithOption()
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $expected  = '/clusters/' . $clusterId . '/services';

        // Test
        $request->pathParameter('ClusterId', $clusterId);
        $method = new ReflectionMethod(
            Path::class,
            'assign'
        );
        $actual = $method->invokeArgs($request, [$request->pathPattern, $request->pathParameters]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @throws ReflectionException
     * @throws ClientException
     */
    public function testConstructAcsHeader()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
        $request->withClusterId(\time());
        $request->regionId('cn-hangzhou');
        $clusterId = \time();
        $request->resolveParameter();
        $expected = "x-acs-region-id:cn-hangzhou\n" .
                    "x-acs-signature-method:HMAC-SHA1\n";

        // Test
        $request->pathParameter('ClusterId', $clusterId);
        $method = new ReflectionMethod(
            Sign::class,
            'acsHeaderString'
        );
        $method->setAccessible(true);

        $requestPsr = new Request(
            $request->method,
            $request->uri,
            $request->getHeaders()
        );

        $actual = $method->invokeArgs($request, [$requestPsr->getHeaders()]);

        // Assert
        self::assertTrue(Stringy::create($actual)->contains($expected));
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
                    ->asDefaultClient();

        // Test
        $request->options(['query' => $query]);
        $request->resolveParameter();

        // Assert
        self::assertEquals($expected, Encode::create($request->options['query'])->ksort()->toString());
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
     * @dataProvider contentType
     */
    public function testContentType($format, $expected)
    {
        self::assertEquals($expected, Accept::create($format)->toString());
    }

    /**
     * @return array
     */
    public function contentType()
    {
        return [
            ['JSON', 'application/json',],
            ['XML', 'application/xml',],
            ['RAW', 'application/octet-stream',],
            ['NON', 'application/octet-stream',],
            ['FORM', 'application/x-www-form-urlencoded',],
        ];
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @dataProvider pathParameter
     * @throws ClientException
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Name cannot be empty
     * @throws ClientException
     */
    public function testPathParameterWithNameEmpty()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->pathParameter('', 'value');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Name must be a string
     * @throws ClientException
     */
    public function testPathParameterWithNameFormat()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->pathParameter(null, 'value');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Value cannot be empty
     * @throws ClientException
     */
    public function testPathParameterWithValueEmpty()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->pathParameter('name', '');
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
     * @throws ClientException
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
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Pattern cannot be empty
     * @throws ClientException
     */
    public function testPathPatternWithEmpty()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->pathPattern('');
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Pattern must be a string
     * @throws ClientException
     */
    public function testPathPatternWithFormat()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->pathPattern(null);
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
                    ->asDefaultClient();

        // Test
        $request->version($version);
        $request->resolveParameter();

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
     * @return array
     * @throws ClientException
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
     * @throws       ClientException
     * @dataProvider resolveQuery
     */
    public function testResolveParameters()
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
        $request->resolveParameter();

        // Assert
        self::assertEquals($expected, (string)$request->uri);
    }

    /**
     * @throws ClientException
     */
    public function testCall()
    {
        $request = new RoaRequest();
        self::assertEquals([], $request->pathParameters);

        $request->withPrefix('with');
        self::assertEquals('with', $request->getPrefix());
        self::assertEquals(['Prefix' => 'with',], $request->pathParameters);

        $request->withprefix('with');
        self::assertEquals('with', $request->getprefix());
        self::assertEquals(['Prefix' => 'with', 'prefix' => 'with',], $request->pathParameters);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Call to undefined method AlibabaCloud\Client\Request\RoaRequest::nowithvalue()
     * @throws ClientException
     */
    public function testCallException()
    {
        $request = new RoaRequest();
        $request->nowithvalue('value');
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Please use withParameter instead of setParameter
     * @throws ClientException
     */
    public function testExceptionWithSet()
    {
        $request = AlibabaCloud::roa();
        $request->setParameter();
    }

    /**
     * @covers \AlibabaCloud\Client\Request\RoaRequest::resolveSecurityToken
     * @throws ReflectionException
     * @throws ClientException
     */
    public function testResolveSecurityToken()
    {
        // Setup
        $request = AlibabaCloud::roa();
        $object  = new ReflectionObject($request);
        AlibabaCloud::stsClient('foo', 'bar', 'token')->asDefaultClient();

        // Test
        $method = $object->getMethod('resolveSecurityToken');
        $method->setAccessible(true);
        $method->invoke($request);

        // Assert
        self::assertEquals('token', $request->options['headers']['x-acs-security-token']);
    }

    /**
     * @covers \AlibabaCloud\Client\Request\RoaRequest::resolveSecurityToken
     * @throws ReflectionException
     * @throws ClientException
     */
    public function testNoSecurityToken()
    {
        // Setup
        $request = AlibabaCloud::roa();
        $object  = new ReflectionObject($request);
        AlibabaCloud::stsClient('foo', 'bar')->asDefaultClient();

        // Test
        $method = $object->getMethod('resolveSecurityToken');
        $method->setAccessible(true);
        $method->invoke($request);

        // Assert
        self::assertFalse(isset($request->options['headers']['x-acs-security-token']));
    }
}
