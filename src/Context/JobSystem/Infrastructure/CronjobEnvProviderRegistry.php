<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\Provider\CronjobEnvValueProviderInterface;
use RuntimeException;

final class CronjobEnvProviderRegistry
{
    /** @var array<string, CronjobEnvValueProviderInterface> */
    private array $providerMap = [];

    public function __construct(iterable $providers)
    {
        foreach ($providers as $provider) {
            $this->providerMap[$provider::key()] = $provider;
        }
    }

    public function get(string $key): CronjobEnvValueProviderInterface
    {
        if (!isset($this->providerMap[$key])) {
            throw new RuntimeException("No provider found for key: $key");
        }

        return $this->providerMap[$key];
    }
}
