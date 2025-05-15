<?php

namespace App\Context\JobSystem\Domain;

class JobStatusCode
{
    public function __construct(
        public readonly int $value
    )
    {
    }

    public static function new(?int $value): ?self
    {
        if($value === null)
        {
            return null;
        }

        return new self(value: $value);
    }
}