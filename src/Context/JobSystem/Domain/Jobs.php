<?php

declare(strict_types=1);

namespace App\Context\JobSystem\Domain;

class Jobs
{

    /**
     * @param Job[] $jobs
     */
    private function __construct(public readonly array $jobs)
    {
    }


    /**
     * @param Job[] $jobs
     */
    public static function new(array $jobs): self
    {
        return new self(
            jobs: $jobs
        );
    }

}