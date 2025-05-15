<?php

namespace App\Context\JobSystem\Infrastructure;

final class CronjobEnvPlaceholderSubstitutor
{
    public function __construct(
        private readonly CronjobEnvProviderRegistry $registry
    ) {}

    public function substitute(array $fileData): array
    {
        foreach ($fileData as $key => $value) {
            if (is_array($value)) {
                $fileData[$key] = $this->substitute($value);

                if (isset($value['env']['valueFrom'])) {
                    $envKey = $value['env']['valueFrom'];

                    $provider = $this->registry->get($envKey);
                    $fileData[$key] = $provider->value();
                }
            }
        }

        return $fileData;
    }
}
