<?php

namespace Nighten\ApiClient;

use Nighten\ApiClient\Response\ResponseHandlerInterface;
use GuzzleHttp\Psr7\Response;

interface ResponseHandlerAwareInterface
{
    public function getResponseHandler(): ResponseHandlerInterface;
}
