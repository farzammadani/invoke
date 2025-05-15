<?php

namespace App\Context\Provider;

class InMemoryCronJobEnvProvider implements CronjobEnvValueProviderInterface
{
    public function value(): string
    {
        return 'Bearer STATIC_TEST_TOKEN';
    }

    public static function key(): string
    {
        return 'API_ENDPOINT_TOKEN';
    }
}