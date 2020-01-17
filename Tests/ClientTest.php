<?php

namespace Nighten\ApiClient\Tests;

use Nighten\ApiClient\AuthenticationProviderInterface;
use Nighten\ApiClient\DefaultAuthenticationProvider;
use Nighten\ApiClient\Response\DefaultClientResponse;
use Nighten\ApiClient\Tests\Mock\TestHttpClient;
use Nighten\ApiClient\Tests\Mock\TestLogger;
use Nighten\ApiClient\Tests\Mock\TestRequest;
use Nighten\ApiClient\Tests\Mock\TestRequestWithHandler;
use Nighten\ApiClient\Tests\Mock\TestResponseHandler;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Nighten\ApiClient\Client;

class ClientTest extends TestCase
{
    private const HOST = 'http://test-host';
    private Client $client;
    private ClientInterface $httpClient;

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Client::class, $this->client);
    }

    public function testRequest(): void
    {
        $this->client->request($this->getTestRequest());
        $this->assertEquals('method', $this->httpClient->getMethod());
        $this->assertEquals(self::HOST . '/path', $this->httpClient->getUri());
        $this->assertEquals(['body' => 'raw body'], $this->httpClient->getOptions());
    }

    private function getTestRequest(): TestRequest
    {
        return new TestRequest('/path', 'raw body', 'method');
    }

    public function testWithSlashInHost(): void
    {
        $client = new Client(
            'https://test-host-with-slash/',
            $this->httpClient
        );
        $client->request($this->getTestRequest());
        $this->assertEquals('https://test-host-with-slash/path', $this->httpClient->getUri());
    }

    public function testTimeoutSetter(): void
    {
        $this->client->setTimeout(10);
        $this->client->request($this->getTestRequest());
        $this->assertEquals(['body' => 'raw body', 'timeout' => 10], $this->httpClient->getOptions());
        $this->client->setTimeout(8.5);
        $this->client->request($this->getTestRequest());
        $this->assertEquals(['body' => 'raw body', 'timeout' => 8.5], $this->httpClient->getOptions());
    }

    public function testHttpClientSetter(): void
    {
        $client = new Client(self::HOST);
        $client->setHttpClient($this->httpClient);
        $this->assertEquals($this->httpClient, $client->getHttpClient());
        $this->assertEquals([], $this->httpClient->getOptions());
        $client->request($this->getTestRequest());
        $this->assertEquals(['body' => 'raw body'], $this->httpClient->getOptions());
    }

    public function testLoggerSetter(): void
    {
        $logger = new TestLogger();
        $this->client->setLogger($logger);
        $this->client->request($this->getTestRequest());
        $log = $logger->getLog();
        $this->assertCount(1, $log['info']);
    }

    public function testDefaultRequestResponseHandler(): void
    {
        /** @var DefaultClientResponse $response */
        $response = $this->client->request($this->getTestRequest());
        $this->assertInstanceOf(DefaultClientResponse::class, $response);
        $this->assertArrayHasKey('test_response', $response->getPayload());
        $this->assertTrue($response->getPayload()['test_response']);
    }

    public function testRequestResponseHandler(): void
    {
        $response = $this->client->request(new TestRequestWithHandler('/path', 'raw body', 'method'));
        $this->assertIsArray($response);
        $this->assertArrayHasKey('test_response_handler', $response);
        $this->assertTrue($response['test_response_handler']);
    }

    public function testResponseHandlerSetter(): void
    {
        $this->client->setResponseHandler(new TestResponseHandler());
        $response = $this->client->request($this->getTestRequest());
        $this->assertIsArray($response);
        $this->assertArrayHasKey('test_response_handler', $response);
        $this->assertTrue($response['test_response_handler']);
    }

    public function testAuthentication(): void
    {
        $this->client->setAuthenticationProvider(new DefaultAuthenticationProvider('api-key'));
        $this->client->request($this->getTestRequest());
        $options = $this->httpClient->getOptions();
        $this->assertArrayHasKey('headers', $options);
        $this->assertArrayHasKey('Authorization', $options['headers']);
        $this->assertEquals('api-key', $options['headers']['Authorization']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->httpClient = new TestHttpClient();
        $this->client = new Client(
            self::HOST,
            $this->httpClient
        );
    }
}
