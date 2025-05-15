<?php

namespace App\Context\JobSystem\Domain;

interface PerformedJobsRepositoryInterface
{
    public function hasRunInLastMinute(Job $job, \DateTimeImmutable $now): bool;

    public function record(PerformedJobResult $result, \DateTimeImmutable $now): void;
}
