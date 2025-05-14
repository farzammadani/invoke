<?php
declare(strict_types=1);
namespace App\Context\JobSystem\Domain;

class JobPayload
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