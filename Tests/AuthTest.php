<?php

namespace Nighten\ApiClient\Tests;

use Nighten\ApiClient\Request\AuthRequest;
use Nighten\ApiClient\Response\Auth\AuthResponseHandler;
use Nighten\ApiClient\Tests\Mock\TestResponse;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    public function testAuthRequest(): void
    {
        $request = new AuthRequest('login', 'password');
        $this->assertEquals('{"login":"login","password":"password"}', $request->getBody());
        $this->assertEquals('/login/', $request->getPath());
        $this->assertEquals('POST', $request->getMethod());
        $this->assertInstanceOf(AuthResponseHandler::class, $request->getResponseHandler());
    }

    /**
     * @dataProvider authResponseHandlerDataProvider
     * @param string $body
     * @param bool $isAuth
     * @param int|null $userId
     * @param string|null $key
     */
    public function testAuthResponseHandler(string $body, bool $isAuth, ?int $userId, ?string $key): void
    {
        $responseHandler = new AuthResponseHandler();
        $httpResponse = new TestResponse(200, [], $body);
        $authResponse = $responseHandler->handle($httpResponse);
        $this->assertEquals($isAuth, $authResponse->isAuth());
        $this->assertEquals($userId, $authResponse->getUserId());
        $this->assertEquals($key, $authResponse->getKey());
    }

    public function authResponseHandlerDataProvider(): array
    {
        return [
            ['{"somefiled":1}', false, null, null],
            ['{"user_id":1}', false, null, null],
            ['{"key":"userkey"}', false, null, null],
            ['{"user_id":1, "key":"userkey"}', true, 1, 'userkey'],
        ];
    }
}
