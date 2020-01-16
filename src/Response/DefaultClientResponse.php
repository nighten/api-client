<?php

namespace Nighten\ApiClient\Response;

class DefaultClientResponse
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @codeCoverageIgnore
     */
    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
