<?php

namespace App\Context\Job\Presentation;

use App\Context\Job\Domain\JobDefinition;
use App\Context\Job\Domain\JobRepositoryInterface;
use App\Context\Job\Infrastructure\YamlJobLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:sync-from-yaml')]
class SyncFromYamlCommand extends Command
{
    private YamlJobLoader $loader;
    private JobRepositoryInterface $repository;

    public function __construct(YamlJobLoader $loader, JobRepositoryInterface $repository)
    {
        parent::__construct();
        $this->loader = $loader;
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this->setDescription('Syncs cronjobs from YAML files to repository.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->loader->load();
        foreach ($data as $item) {
            $definition = new JobDefinition($item);
            $this->repository->save($definition);
            $output->writeln("Synced: {$definition->name}");
        }
        return Command::SUCCESS;
    }
}
