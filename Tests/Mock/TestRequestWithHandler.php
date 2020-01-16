<?php

namespace Nighten\ApiClient\Tests\Mock;

use Nighten\ApiClient\Request\RequestInterface;
use Nighten\ApiClient\Response\ResponseHandlerInterface;
use Nighten\ApiClient\ResponseHandlerAwareInterface;

class TestRequestWithHandler implements RequestInterface, ResponseHandlerAwareInterface
{
    private string $path;
    private string $body;
    private string $method;

    public function __construct(string $path, string $body, string $method)
    {
        $this->path = $path;
        $this->body = $body;
        $this->method = $method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getResponseHandler(): ResponseHandlerInterface
    {
        return new TestResponseHandler();
    }
}
