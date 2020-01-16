<?php

namespace Nighten\ApiClient\Request;

use Nighten\ApiClient\Response\Auth\AuthResponseHandler;
use Nighten\ApiClient\Response\ResponseHandlerInterface;
use Nighten\ApiClient\ResponseHandlerAwareInterface;

class AuthRequest implements RequestInterface, ResponseHandlerAwareInterface
{
    private string $login;

    private string $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getPath(): string
    {
        return '/login/';
    }

    public function getBody(): string
    {
        return json_encode([
            'login' => $this->login,
            'password' => $this->password
        ], JSON_THROW_ON_ERROR);
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getResponseHandler(): ResponseHandlerInterface
    {
        return new AuthResponseHandler();
    }
}
