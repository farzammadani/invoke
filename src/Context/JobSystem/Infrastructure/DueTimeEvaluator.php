<?php
declare(strict_types=1);
namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use Cron\CronExpression;

class DueTimeEvaluator
{
    public function checkIsDueNow(Job $job, \DateTimeImmutable $now): bool
    {
        try {
            $cron = new CronExpression(expression: $job->schedule->value);
            return $cron->isDue($now);
        }
        catch (\Throwable $e)
        {
            // If the cron expression fails, skip the job gracefully
            return false;
        }

    }

}