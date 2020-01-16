<?php

namespace Nighten\ApiClient\Response\Auth;

use Nighten\ApiClient\Response\ResponseHandlerInterface;
use GuzzleHttp\Psr7\Response;

class AuthResponseHandler implements ResponseHandlerInterface
{
    public function handle(Response $response): AuthResponse
    {
        $decoded = json_decode($response->getBody(), true);
        if (array_key_exists('user_id', $decoded) && array_key_exists('key', $decoded)) {
            return new AuthResponse(true, $decoded['user_id'], $decoded['key']);
        }
        return new AuthResponse(false);
    }
}
