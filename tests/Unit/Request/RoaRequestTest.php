<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

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
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
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
        $request->setClusterId($clusterId);
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
    public function testBuildCanonicalHeaders()
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();
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
            'buildCanonicalHeaders'
        );
        $method->setAccessible(true);
        $actual = $method->invoke($request);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @param $uri
     * @param $expected
     *
     * @throws       \ReflectionException
     * @dataProvider splitSubResource
     */
    public function testSplitSubResource($uri, $expected)
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();

        // Test
        $request->pathParameter('ClusterId', $clusterId);
        $method = new \ReflectionMethod(
            DescribeClusterServicesRequest::class,
            'splitSubResource'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, [$uri]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function splitSubResource()
    {
        return [
            [
                '/clusters/1234/services?a=a&b=b',
                [
                    0 => '/clusters/1234/services',
                    1 => 'a=a&b=b',
                ],
            ],
            [
                '/clusters/1234/services',
                [
                    0 => '/clusters/1234/services',
                ],
            ],
        ];
    }

    /**
     * @param $expected
     * @param $uri
     *
     * @throws       \ReflectionException
     * @dataProvider buildQueryString
     */
    public function testBuildQueryString($expected, $uri)
    {
        // Setup
        $request   = new  DescribeClusterServicesRequest();
        $clusterId = \time();
        $request->options(
            [
                'query' => [
                    'Abc' => 'Abc',
                ],
            ]
        );

        // Test
        $request->pathParameter('ClusterId', $clusterId);
        $method = new \ReflectionMethod(
            DescribeClusterServicesRequest::class,
            'buildQueryString'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, [$uri]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function buildQueryString()
    {
        return [
            [
                '/clusters/1234/services?Abc=Abc&Version=2015-12-15&a=a&b=b',
                '/clusters/1234/services?a=a&b=b',
            ],
            [
                '/clusters/1234/services?Abc=Abc&Version=2015-12-15',
                '/clusters/1234/services',
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
     */
    public function testVersion($version)
    {
        // Setup
        $request = new  DescribeClusterServicesRequest();

        // Test
        $request->version($version);

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
            ['setGG', 'getGG', 'value', 'value'],
            ['setGG', 'getNone', 'value', null],
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
        $request = new  DescribeClusterServicesRequest();
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
        $expected = 'http://localhost/clusters/[ClusterId]/services?A=A&Version=2015-12-15';

        // Test
        $request->resolveParameters($credential);

        // Assert
        self::assertEquals($expected, $request->uri);
    }
}
