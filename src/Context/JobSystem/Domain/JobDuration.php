<?php
declare(strict_types=1);
namespace App\Context\JobSystem\Domain;

class JobDuration
{
    public function __construct(
        public readonly int $value
    )
    {
    }

    public static function new(int $value): self
    {
        return new self(value: $value);
    }
}