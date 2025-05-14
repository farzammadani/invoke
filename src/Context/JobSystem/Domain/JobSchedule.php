<?php

namespace App\Context\JobSystem\Domain;

class JobSchedule
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