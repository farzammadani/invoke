<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Domain\Jobs;
use App\Context\Provider\CronJobsFolderAddressProvider;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class YamlJobParser
{
    // TODO: Support environment variable substitution using references in the YAML file (e.g., for credentials, tokens).
    public function parse(): Jobs
    {
        // set empty list of jobs
        $jobs = [];
        // create instance of finder
        $finder = new Finder();
        // finder -> files -> in  pass folder address  -> name *.yaml
        $finder->files()->in(CronJobsFolderAddressProvider::value())->name('*.yaml');
        // for each finder (will actually host a list now) as file:
        foreach ($finder as $file) {
            // data = yaml parsefile  pass in file->getRealPath()
            $fileData = Yaml::parseFile($file->getRealPath());
            // see if it is enabled. if not enabled (continue)...
            if(!self::jobIsActive($fileData))
            {
                continue;
            }

            $fileData = CronjobEnvPlaceholderSubstitutor::substitute(fileData: $fileData);
            // Create Job object out of it and add to Jobs[]
            $jobs[] = Job::new(
                jobName: $fileData['name'],
                jobSchedule: $fileData['schedule'],
                jobUrl: $fileData['url'],
                jobMethod: $fileData['method'],
                jobHeaders: $fileData['headers'] ?? [],
                jobPayload: $fileData['payload'] ?? [],
                jobActiveState: $fileData['enabled']
            );
        }

        $jobs = Jobs::new(jobs: $jobs);
        return $jobs;
    }

    private static function jobIsActive(array $fileData): bool
    {
        return $fileData['enabled'] === true;
    }

}