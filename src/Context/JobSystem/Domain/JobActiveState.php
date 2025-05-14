<?php

namespace App\Context\JobSystem\Domain;

class JobActiveState
{
    private function __construct(
        public readonly bool $value
    )
    {
    }

    public static function new(bool $value): self
    {
        return new self(value: $value);
    }
}