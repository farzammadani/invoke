<?php

namespace App\DevTool;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Infrastructure\JobRunner;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// Note: Make sure to run `make stub-server` before using this command to start the stub server.
#[AsCommand(
    name: 'dev:job:run',
    description: 'Runs a job against a hardcoded stub endpoint (for dev testing only)'
)]
class RunJobCommand extends Command
{
    public function __construct(private readonly JobRunner $jobRunner)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 🔧 Hardcoded stub URL — update if your stub server is elsewhere
        $stubUrl = 'http://localhost:9999';

        $job = Job::new(
            jobName: 'DevStubJob',
            jobSchedule: '* * * * *',
            jobUrl: $stubUrl,
            jobMethod: 'POST',
            jobHeaders: ['Content-Type' => 'application/json'],
            jobPayload: ['message' => 'Hello from dev command'],
            jobActiveState: true
        );

        $result = $this->jobRunner->run($job);

        $output->writeln("✅ Status: " . ($result->jobSuccessState->value ? 'Success' : 'Failure'));
        $output->writeln("📦 HTTP Code: {$result->jobStatusCode->value}");
        $output->writeln("⏱ Duration: {$result->jobDuration->value} ms");
        $output->writeln("📝 Message: " . $result->jobResultMessage->value);

        return Command::SUCCESS;
    }
}
