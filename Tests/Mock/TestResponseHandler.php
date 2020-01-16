<?php

namespace Nighten\ApiClient\Tests\Mock;

use Nighten\ApiClient\Response\ResponseHandlerInterface;
use GuzzleHttp\Psr7\Response;

class TestResponseHandler implements ResponseHandlerInterface
{
    public function handle(Response $response)
    {
        return ['test_response_handler' => true];
    }
}
