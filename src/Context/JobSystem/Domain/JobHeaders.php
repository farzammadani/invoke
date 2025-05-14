<?php

namespace App\Context\JobSystem\Domain;

class JobHeaders
{
    private function __construct(
        public readonly array $value
    )
    {
    }

    public static function new(array $value): self
    {
        return new self(value: $value);
    }
}