<?php

declare(strict_types=1);
namespace App\Context\JobSystem\Domain;

class JobResultMessage
{
    private function __construct(
        public readonly string $value
    )
    {
    }

    public static function new(string $value): self
    {
        return new self(
            value: $value
        );
    }

}