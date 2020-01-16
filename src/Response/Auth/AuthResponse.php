<?php

namespace Nighten\ApiClient\Response\Auth;

class AuthResponse
{
    private bool $isAuth;
    private ?int $userId;
    private ?string $key;

    public function __construct(bool $isAuth, ?int $userId = null, ?string $key = null)
    {
        $this->isAuth = $isAuth;
        $this->userId = $userId;
        $this->key = $key;
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->isAuth;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }
}
