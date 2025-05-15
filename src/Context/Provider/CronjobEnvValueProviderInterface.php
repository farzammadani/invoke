<?php

namespace App\Context\Provider;

interface CronjobEnvValueProviderInterface
{
    public function value(): string;
    public static function key(): string;
}
