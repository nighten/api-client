<?php

namespace Nighten\ApiClient\Tests\Mock;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class TestHttpClient implements ClientInterface
{
    private string $method;
    private string $uri;
    private array $options = [];

    public function send(RequestInterface $request, array $options = [])
    {
        // TODO: Implement send() method.
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
        // TODO: Implement sendAsync() method.
    }

    public function request($method, $uri, array $options = [])
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->options = $options;
        return new TestResponse(200, [], '{"test_response":true}');
    }

    public function requestAsync($method, $uri, array $options = [])
    {
        // TODO: Implement requestAsync() method.
    }

    public function getConfig($option = null)
    {
        // TODO: Implement getConfig() method.
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
