<?php

namespace App\Context\Provider;

final class InMemoryCronJobsFolderAddressProvider implements CronJobsFolderAddressProviderInterface
{
    public function value(): string
    {
        $path = realpath(__DIR__ . '/../../../tests/test_data/cronjobs');

        if (!$path) {
            throw new \RuntimeException('Test cronjobs folder not found.');
        }

        return $path;
    }
}