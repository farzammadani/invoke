<?php

namespace App\Context\JobSystem\Domain;

interface PerformedJobsRepositoryInterface
{
    public function hasRunInLastMinute(Job $job, \DateTimeImmutable $now): bool;

    public function save(PerformedJobResult $result, \DateTimeImmutable $now): void;
}
