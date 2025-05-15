<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Domain\PerformedJobResult;
use App\Context\JobSystem\Domain\PerformedJobsRepositoryInterface;
use Doctrine\DBAL\Connection;

class PerformedJobsRepository implements PerformedJobsRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {}

    public function hasRunInLastMinute(Job $job, \DateTimeImmutable $now): bool
    {
        $minuteStart = $now->setTime(
            (int) $now->format('H'),
            (int) $now->format('i'),
            0
        );

        $sql = 'SELECT 1
        FROM performed_jobs
        WHERE job_name = :jobName AND ran_at >= :minuteStart
        LIMIT 1';

        return (bool) $this->connection->fetchOne($sql, [
            'jobName'     => $job->name->value,
            'minuteStart' => $minuteStart->format('Y-m-d H:i:s'),
        ]);
    }

    public function save(PerformedJobResult $result, \DateTimeImmutable $now): void
    {
//        dd([
//            'job_name'    => $result->jobName->value,
//            'ran_at'      => $now->format('Y-m-d H:i:s'),
//            'status_code' => $result->jobStatusCode?->value,
//            'duration_ms' => $result->jobDuration->value,
//            'success'     => $result->jobSuccessState?->value,
//            'cast_success'=> $result->jobSuccessState?->value === true,
//            'message'     => $result->jobResultMessage->value,
//        ]);

        $this->connection->insert('performed_jobs', [
            'job_name'    => $result->jobName->value,
            'ran_at'      => $now->format('Y-m-d H:i:s'),
            'status_code' => $result->jobStatusCode?->value ?? 0, // fallback to 0 or -1 if null
            'duration_ms' => $result->jobDuration->value,
            'success'     => $result->jobSuccessState?->value === true,
            'message'     => $result->jobResultMessage->value,
        ]);
    }
}
