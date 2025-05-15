<?php

namespace CronValueProviders;

final class ApiEndpointTokenProvider
{
    public static function value(): string
    {
        $token = $_ENV['API_ENDPOINT_TOKEN'] ?? getenv('API_ENDPOINT_TOKEN');

        if (!$token) {
            throw new \RuntimeException('Missing required environment variable: API_ENDPOINT_TOKEN');
        }

        return 'Bearer ' . $token;
    }
}
