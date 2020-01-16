<?php

namespace Nighten\ApiClient\Response;

use GuzzleHttp\Psr7\Response;

interface ResponseHandlerInterface
{
    public function handle(Response $response);
}
