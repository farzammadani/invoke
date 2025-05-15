<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Domain\PerformedJobResult;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class JobRunner
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
    )
    {
    }

    public function run(Job $job): PerformedJobResult
    {
        $start = microtime(true);

        try {
            $response = $this->httpClient->request(
                method: $job->method->value,
                url: $job->jobUrl->value,
                options: [
                    'headers' => $job->headers->value,
                    'json' => $job->payload->value,
                    'timeout' => 10,
                ]
            );

            $statusCode = $response->getStatusCode();
            $content = $response->getContent(false); // don't throw on HTTP error codes

        } catch (\Throwable $e) {
            return PerformedJobResult::new(
                jobName: $job->name->value,
                jobSuccessState: false,
                jobStatusCode: null,
                jobDuration: self::calculateJobDuration(startTime: $start),
                jobResultMessage: $e->getMessage()
            );
        }

        return PerformedJobResult::new(
            jobName: $job->name->value,
            jobSuccessState: self::getSuccessState($statusCode),
            jobStatusCode: $statusCode,
            jobDuration: self::calculateJobDuration(startTime: $start),
            jobResultMessage: $content
        );


    }

    private static function calculateJobDuration($startTime): int
    {
        return (int)((microtime(true) - $startTime) * 100);
    }

    private static function getSuccessState(int $statusCode): bool
    {
        return $statusCode >= 200 && $statusCode < 300;
    }
}