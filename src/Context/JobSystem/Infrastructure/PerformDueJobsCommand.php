<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\PerformedJobsRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:perform-due',
    description: 'Evaluates due jobs from YAML and executes them'
)]
class PerformDueJobsCommand extends Command
{
    public function __construct(
        private readonly YamlJobParser $parser,
        private readonly DueTimeEvaluator $evaluator,
        private readonly JobRunner $runner,
        private readonly PerformedJobsRepositoryInterface $repository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTimeImmutable();
        $jobs = $this->parser->parse();

        foreach ($jobs->jobs as $job) {
            if (!$this->evaluator->checkIsDueNow($job, $now)) {
                $output->writeln("⏩ Not due: {$job->name->value}");
                continue;
            }

            if ($this->repository->hasRunInLastMinute($job, $now)) {
                $output->writeln("🔁 Skipped (already ran): {$job->name->value}");
                continue;
            }

            $output->writeln("🚀 Running: {$job->name->value}");
            $result = $this->runner->run($job);
            $this->repository->save($result, $now);

            $statusEmoji = $result->jobSuccessState->value ? '✅' : '❌';
            $output->writeln("   {$statusEmoji} Status: {$result->jobStatusCode?->value}, Duration: {$result->jobDuration->value}ms");
        }

        return Command::SUCCESS;
    }
}
