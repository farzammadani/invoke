<?php

namespace App\Context\JobSystem\Domain;

class PerformedJobResult
{
    private function __construct(
        public readonly JobName $jobName,
        public readonly JobSuccessState $jobSuccessState,
        public readonly ?JobStatusCode $jobStatusCode,
        public readonly JobDuration $jobDuration,
        public readonly JobResultMessage $jobResultMessage
    )
    {
    }


    public static function new(string $jobName, bool $jobSuccessState, ?int $jobStatusCode, int $jobDuration, string $jobResultMessage): self
    {
        return new self(
            jobName: JobName::new($jobName),
            jobSuccessState: JobSuccessState::new($jobSuccessState),
            jobStatusCode: JobStatusCode::new($jobStatusCode),
            jobDuration: JobDuration::new($jobDuration),
            jobResultMessage: JobResultMessage::new($jobResultMessage)
        );
    }


}