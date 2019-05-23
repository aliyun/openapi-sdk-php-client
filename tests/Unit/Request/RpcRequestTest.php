<?php

namespace AlibabaCloud\Client\Tests\Unit\Request;

use ReflectionMethod;
use ReflectionObject;
use RuntimeException;
use ReflectionException;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\Support\Sign;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Credentials\StsCredential;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Credentials\CredentialsInterface;
use AlibabaCloud\Client\Credentials\BearerTokenCredential;

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
     * @return array
     */
    public static function boolToString()
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
     * @param $value
     * @param $expected
     *
     * @throws       ReflectionException
     * @throws ClientException
     * @dataProvider boolToString
     */
    public function testBoolToString($value, $expected)
    {
        // Setup
        $request = new  RpcRequest();

        // Test
        $method = new ReflectionMethod(
            RpcRequest::class,
            'boolToString'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, [$value]);

        // Assert
        self::assertEquals($expected, $actual);
    }

    /**
     * @param CredentialsInterface $credential
     *
     * @throws       ReflectionException
     * @throws ClientException
     * @dataProvider resolveQuery
     */
    public function testResolveCommonParameters($credential)
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
        $method = new ReflectionMethod(
            RpcRequest::class,
            'resolveCommonParameters'
        );
        $method->setAccessible(true);
        $method->invokeArgs($request, [$credential]);

        // Assert
        self::assertInternalType('array', $request->options['query']);
        self::assertEquals('A', $request->options['query']['A']);
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
     * @param CredentialsInterface $credential
     *
     * @throws       ReflectionException
     * @throws ClientException
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
        $method = new ReflectionMethod(
            RpcRequest::class,
            'resolveParameter'
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
     * @throws       ReflectionException
     * @throws ClientException
     * @dataProvider percentEncode
     */
    public function testPercentEncode($value, $expected)
    {
        // Setup
        $request = new  RpcRequest();

        // Test
        $method = new ReflectionMethod(
            Sign::class,
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
     * @param $expected
     *
     * @throws       ReflectionException
     * @throws ClientException
     * @dataProvider signature
     */
    public function testSignature($parameters, $expected)
    {
        // Setup
        $request                   = new  RpcRequest();
        $request->options['query'] = $parameters;

        // Test
        $method = new ReflectionMethod(
            RpcRequest::class,
            'signature'
        );
        $method->setAccessible(true);
        $actual = $method->invokeArgs($request, []);

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
                'liZ2rLCylB5dy2kwxbuTa/BY5Uw=',
            ],
            [
                [3, 4],
                'gAQmuhD1C77I3WEgo4j1k+bFfss=',
            ],
        ];
    }

    /**
     * @throws ClientException
     */
    public function testCall()
    {
        $request = new RpcRequest();

        $request->withPrefix('with');
        self::assertEquals('with', $request->getPrefix());
        self::assertEquals(['Prefix' => 'with',], $request->options['query']);

        $request->withprefix('with');
        self::assertEquals('with', $request->getprefix());
        self::assertEquals(['Prefix' => 'with', 'prefix' => 'with',], $request->options['query']);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Call to undefined method AlibabaCloud\Client\Request\RpcRequest::nowithvalue()
     * @throws ClientException
     */
    public function testCallException()
    {
        $request = new RpcRequest();
        $request->nowithvalue('value');
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Please use withParameter instead of setParameter
     */
    public function testExceptionWithSet()
    {
        $request = AlibabaCloud::rpc();
        $request->setParameter();
    }

    /**
     * @covers \AlibabaCloud\Client\Request\RpcRequest::resolveSecurityToken
     * @throws ReflectionException
     * @throws ClientException
     */
    public function testResolveSecurityToken()
    {
        // Setup
        AlibabaCloud::stsClient('foo', 'bar', 'token')->name('resolveSecurityToken');
        $request = AlibabaCloud::rpc()->client('resolveSecurityToken');
        $object  = new ReflectionObject($request);

        // Test
        $method = $object->getMethod('resolveSecurityToken');
        $method->setAccessible(true);
        $method->invoke($request);

        // Assert
        self::assertEquals('token', $request->options['query']['SecurityToken']);
    }

    /**
     * @covers \AlibabaCloud\Client\Request\RoaRequest::resolveSecurityToken
     * @throws ReflectionException
     * @throws ClientException
     */
    public function testNoSecurityToken()
    {
        // Setup
        $request = AlibabaCloud::rpc();
        $object  = new ReflectionObject($request);
        AlibabaCloud::stsClient('foo', 'bar')->asDefaultClient();

        // Test
        $method = $object->getMethod('resolveSecurityToken');
        $method->setAccessible(true);
        $method->invoke($request);

        // Assert
        self::assertFalse(isset($request->options['query']['SecurityToken']));
    }
}
