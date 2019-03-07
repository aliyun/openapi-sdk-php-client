<?php

namespace AlibabaCloud\Client\Tests\Unit;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\DefaultAcsClient;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Profile\DefaultProfile;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Client\SDK;
use AlibabaCloud\Client\Tests\Mock\Services\Ecs\DescribeRegionsRequest;
use GuzzleHttp\Psr7\Response;
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

    /**
     * @throws ClientException
     */
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
     * @throws ClientException
     */
    public function testAccessKeyClient()
    {
        $request = new DescribeRegionsRequest();
        $request->body(\time());
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

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Format must be a string
     * @throws ClientException
     * @throws ServerException
     */
    public function testFormatNull()
    {
        $request = new DescribeRegionsRequest();
        $request->format(null);
        $response = self::$client->getAcsResponse($request);
        $this->assertNotNull($response);
    }

    /**
     * @expectedException \AlibabaCloud\Client\Exception\ClientException
     * @expectedExceptionMessage Format cannot be empty
     * @throws ClientException
     * @throws ServerException
     */
    public function testFormatEmpty()
    {
        $request = new DescribeRegionsRequest();
        $request->format('');
        $response = self::$client->getAcsResponse($request);
        $this->assertNotNull($response);
    }

    /**
     * @throws ServerException
     */
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

    /**
     * @throws ServerException
     */
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

    /**
     * @throws ServerException
     */
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
            self::assertEquals(SDK::SERVER_UNREACHABLE, $e->getErrorCode());
        }
    }

    /**
     * @throws ClientException
     */
    public function testBadVersion()
    {
        try {
            $request = new DescribeRegionsRequest();
            $request->version('BadVersion');
            $request->connectTimeout(25);
            $request->timeout(30);
            $response = self::$client->getAcsResponse($request);
            $this->assertNotNull($response);
        } catch (ServerException $e) {
            self::assertEquals(
                'Specified parameter Version is not valid.',
                $e->getErrorMessage()
            );
        }
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testResult()
    {
        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )
                    ->regionId('cn-hangzhou')
                    ->asDefaultClient();

        $result = self::$client->getAcsResponse(new Result(new Response));

        self::assertInstanceOf(Result::class, $result);
    }
}
