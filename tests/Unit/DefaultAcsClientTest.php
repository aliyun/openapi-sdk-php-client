<?php

namespace AlibabaCloud\Client\Tests\Unit;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\DefaultAcsClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Profile\DefaultProfile;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultAcsClientTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit
 *
 * @coversDefaultClass \AlibabaCloud\Client\DefaultAcsClient
 */
class DefaultAcsClientTest extends TestCase
{

    /**
     * @var DefaultProfile
     */
    private static $profile;

    /**
     * @var DefaultAcsClient
     */
    private static $client;

    public function setUp()
    {
        parent::setUp();
        self::$profile = DefaultProfile::getProfile(
            'cn-hangzhou',
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        );
        self::$client  = new DefaultAcsClient(self::$profile);
    }

    /**
     * @throws ServerException
     */
    public function testAccessKeyClient()
    {
        $request = new DescribeRegionsRequest();
        $request->setContent(\time());
        $this->assertEquals(
            \time(),
            $request->getContent()
        );

        $request = new DescribeRegionsRequest();
        $request->addHeader('time', \time());
        $this->assertArrayHasKey('time', $request->getHeaders());

        try {
            $request  = new DescribeRegionsRequest();
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ClientException $e) {
            $this->assertInstanceOf(
                ClientException::class,
                $e
            );
        }
    }

    /**
     * @throws ServerException
     */
    public function testJson()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->format('JSON');
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error ', $e->getMessage());
        }
    }

    public function testRaw()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->format('Raw');
            $result = self::$client->getAcsResponse($request);
            $this->assertInternalType('object', $result);
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error ', $e->getMessage());
        } catch (ServerException $e) {
            self::assertEquals('', $e->getResult()->getResponse()->getBody()->getContents());
        }
    }

    public function testFormatNull()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->format(null);
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error ', $e->getMessage());
        } catch (ServerException $e) {
            self::assertEquals('', $e->getResult()->getResponse()->getBody()->getContents());
        }
    }

    public function testBadMethod()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->method('BadMethod');
            $result = self::$client->getAcsResponse($request);
            self::assertEquals('', (string)$result);
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error ', $e->getMessage());
        }
    }

    public function testPOST()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->setMethod('POST');
            $result = self::$client->getAcsResponse($request);
            self::assertTrue(isset($result['RequestId']));
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error ', $e->getMessage());
        }
    }

    public function testBadProtocol()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->setProtocol('BadProtocol');
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ClientException $e) {
            self::assertStringStartsWith('cURL error ', $e->getMessage());
        }
    }

    public function testBadActionName()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->action('BadActionName');
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ServerException $e) {
            self::assertEquals(
                'The specified parameter "Action or Version" is not valid.',
                $e->getErrorMessage()
            );
        } catch (ClientException $e) {
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    public function testBadProduct()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->timeout(\ALIBABA_CLOUD_TIMEOUT);
            $request->connectTimeout(10);
            $request->product('BadProduct');
            $request->connectTimeout(15);
            $request->timeout(20);
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ClientException $e) {
            $expected = [
                'The specified parameter "Action or Version" is not valid.',
                'Can\'t resolve host for BadProduct in cn-hangzhou, You can specify host via the host() method.',
            ];

            $this->assertContains($e->getErrorMessage(), $expected);
        }
    }

    public function testBadVersion()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->version('BadVersion');
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ServerException $e) {
            self::assertEquals(
                'Specified parameter Version is not valid.',
                $e->getErrorMessage()
            );
        } catch (ClientException $e) {
            // Assert
            self::assertEquals(\ALIBABA_CLOUD_SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    public function testResult()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )
                    ->regionId('cn-hangzhou')
                    ->asGlobalClient();

        $result = self::$client->getAcsResponse(new Result(new \GuzzleHttp\Psr7\Response));

        self::assertInstanceOf(Result::class, $result);
    }
}
