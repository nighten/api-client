<?php

namespace Nighten\ApiClient\Request;

interface RequestInterface
{
    public function getPath(): string;

    public function getBody(): string;

    public function getMethod(): string;
}
