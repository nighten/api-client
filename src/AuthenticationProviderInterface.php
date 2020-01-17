<?php

namespace Nighten\ApiClient;

interface AuthenticationProviderInterface
{
    public function getKey(): string;
}
