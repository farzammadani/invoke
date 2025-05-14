<?php

declare(strict_types=1);

namespace App\Context\JobSystem\Domain;

class Job
{
    private function __construct(
        public readonly JobName $name,
        public readonly JobSchedule $schedule,
        public readonly JobMethod $method,
        public readonly JobHeaders $headers,
        public readonly JobPayload $payload,
        public readonly JobActiveState $enabled
    )
    {
    }


    public static function new(string $jobName, string $jobSchedule, string $jobMethod, array $jobHeaders = [], array $jobPayload = [], bool $jobActiveState = true): self
    {
        return new self(
            name: JobName::new($jobName),
            schedule: JobSchedule::new($jobSchedule),
            method: JobMethod::new($jobMethod),
            headers: JobHeaders::new($jobHeaders),
            payload: JobPayload::new($jobPayload),
            enabled: JobActiveState::new($jobActiveState)
        );
    }


}