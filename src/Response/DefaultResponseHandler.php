<?php

namespace Nighten\ApiClient\Response;

use GuzzleHttp\Psr7\Response;

class DefaultResponseHandler implements ResponseHandlerInterface
{
    public function handle(Response $response): DefaultClientResponse
    {
        return new DefaultClientResponse(json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR));
    }
}
