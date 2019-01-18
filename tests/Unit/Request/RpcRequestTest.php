<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Request\RpcRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RpcRequestTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Request
 *
 * @coversDefaultClass \AlibabaCloud\Client\Request\RpcRequest
 */
class RpcRequestTest extends TestCase
{

    /**
     * @param $value
     * @param $expected
     *
     * @throws       \ReflectionException
     * @dataProvider booleanValueToString
     */
    public function testConstructAcsHeader($value, $expected)
    {
        // Setup
        $request = new  RpcRequest();

        // Test
        $method = new \ReflectionMethod(
            RpcRequest::class,
            'booleanValueToString'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, [$value]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function booleanValueToString()
    {
        return [
            ['true', 'true'],
            ['false', 'false'],
            [true, 'true'],
            [false, 'false'],
            ['string', 'string'],
            [1, 1],
            [null, null],
        ];
    }

    /**
     * @param CredentialsInterface $credential
     *
     * @throws       \ReflectionException
     * @dataProvider resolveQuery
     */
    public function testResolveQuery($credential)
    {
        // Setup
        AlibabaCloud::bearerTokenClient('token')->name('token');
        $request = new  RpcRequest();
        $request->client('token');
        $request->regionId('cn-hangzhou');
        $request->options(
            [
                'query' => [
                    'A' => 'A',
                ],
            ]
        );

        // Test
        $method = new \ReflectionMethod(
            RpcRequest::class,
            'resolveQuery'
        );
        $method->setAccessible(true);
        $method->invokeArgs($request, [$credential]);

        // Assert
        self::assertInternalType('array', $request->options['query']);
        self::assertEquals('A', $request->options['query']['A']);
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
     * @throws       \ReflectionException
     * @dataProvider resolveQuery
     */
    public function testResolveParameters($credential)
    {
        // Setup
        AlibabaCloud::bearerTokenClient('token')->name('token');
        $request = new  RpcRequest();
        $request->client('token');
        $request->regionId('cn-hangzhou');
        $request->method('post');
        $request->options(
            [
                'query' => [
                    'A' => 'A',
                ],
            ]
        );

        // Test
        $method = new \ReflectionMethod(
            RpcRequest::class,
            'resolveParameters'
        );
        $method->setAccessible(true);
        $method->invokeArgs($request, [$credential]);

        // Assert
        self::assertFalse(isset($request->options['query']));
        self::assertEquals('http://localhost', (string)$request->uri);
    }

    /**
     * @param $value
     * @param $expected
     *
     * @throws       \ReflectionException
     * @dataProvider percentEncode
     */
    public function testPercentEncode($value, $expected)
    {
        // Setup
        $request = new  RpcRequest();

        // Test
        $method = new \ReflectionMethod(
            RpcRequest::class,
            'percentEncode'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, [$value]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function percentEncode()
    {
        return [
            ['2018-12-26T05:36:28Z', '2018-12-26T05%3A36%3A28Z'],
            [
                'AccessKeyId=LTAIfoSsg3EaQoip&Action=ListAccessKeys&Format=JSON&RegionId=cn-hangzhou&SignatureMethod=HMAC-SHA1&SignatureNonce=4b22e3fd9f3746ea487b298800b44572&SignatureVersion=1.0&Timestamp=2018-12-26T05%3A36%3A26Z&UserName=1545802586&Version=2015-05-01',
                'AccessKeyId%3DLTAIfoSsg3EaQoip%26Action%3DListAccessKeys%26Format%3DJSON%26RegionId%3Dcn-hangzhou%26SignatureMethod%3DHMAC-SHA1%26SignatureNonce%3D4b22e3fd9f3746ea487b298800b44572%26SignatureVersion%3D1.0%26Timestamp%3D2018-12-26T05%253A36%253A26Z%26UserName%3D1545802586%26Version%3D2015-05-01',
            ],
            [
                'AccessKeyId=LTAIfoSsg3EaQoip&Action=AssumeRole&DurationSeconds=3600&Format=JSON&RegionId=cn-hangzhou&RoleArn=acs%3Aram%3A%3A1483445875618637%3Arole%2Ftest&RoleSessionName=session_name&SignatureMethod=HMAC-SHA1&SignatureNonce=5e87f2b001977f40d261a3b59758048f&SignatureVersion=1.0&Timestamp=2018-12-26T05%3A36%3A23Z&Version=2015-04-01',
                'AccessKeyId%3DLTAIfoSsg3EaQoip%26Action%3DAssumeRole%26DurationSeconds%3D3600%26Format%3DJSON%26RegionId%3Dcn-hangzhou%26RoleArn%3Dacs%253Aram%253A%253A1483445875618637%253Arole%252Ftest%26RoleSessionName%3Dsession_name%26SignatureMethod%3DHMAC-SHA1%26SignatureNonce%3D5e87f2b001977f40d261a3b59758048f%26SignatureVersion%3D1.0%26Timestamp%3D2018-12-26T05%253A36%253A23Z%26Version%3D2015-04-01',
            ],
        ];
    }

    /**
     * @param $parameters
     * @param $accessKeySecret
     * @param $expected
     *
     * @throws       \ReflectionException
     * @dataProvider signature
     */
    public function testSignature($parameters, $accessKeySecret, $expected)
    {
        // Setup
        $request = new  RpcRequest();

        // Test
        $method = new \ReflectionMethod(
            RpcRequest::class,
            'signature'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, [$parameters, $accessKeySecret]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function signature()
    {
        return [
            [
                [1, 2],
                'accessKeySecret',
                '7n82fKAFGRRYjudSFGqdd3SfVDE=',
            ],
            [
                [3, 4],
                'accessKeySecret',
                '7nXrGUUpKF1HPTx48NzVfgQBAqk=',
            ],
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
        $request = new  RpcRequest();

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
}
