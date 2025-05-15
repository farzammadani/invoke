<?php

namespace App\Context\JobSystem\Domain;

class JobUrl
{
    private function __construct(
        public readonly string $value
    )
    {
    }

    public static function new(string $value): self
    {
        return new self(value: $value);
    }

}