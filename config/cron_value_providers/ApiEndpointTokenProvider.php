<?php

namespace CronValueProviders;

use App\Context\Provider\CronjobEnvValueProviderInterface;

final class ApiEndpointTokenProvider implements CronjobEnvValueProviderInterface
{
    public function __construct(private string $token) {}

    public function value(): string
    {
        return 'Bearer ' . $this->token;
    }

    public static function key(): string
    {
        return 'API_ENDPOINT_TOKEN';
    }
}
