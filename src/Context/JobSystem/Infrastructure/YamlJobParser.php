<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Domain\Jobs;
use App\Context\Provider\CronJobsFolderAddressProvider;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class YamlJobParser
{
    public function parse(): Jobs
    {
        // set empty list of jobs
        $jobs = Jobs::new(jobs: []);
        // create instance of finder
        $finder = new Finder();
        // finder -> files -> in  pass folder address  -> name *.yaml
        $finder->files()->in(CronJobsFolderAddressProvider::value())->name('*.yaml');

        // for each finder (will actually host a list now) as file:
        foreach ($finder as $file) {
            // data =   yaml parsefile  pass in file->getRealPath()
            $fileData = Yaml::parseFile($file->getRealPath());
            // see if it is enabled. if not enabled (continue)...
            if(!self::jobIsActive($fileData))
            {
                continue;
            }

            $jobs[] = Job::new(
                jobName: $fileData['name'],
                jobSchedule: $fileData['schedule'],
                jobMethod: $fileData['method'],
                jobHeaders: $fileData['headers'] ?? [],
                jobPayload: $fileData['payload'] ?? [],
                jobActiveState: $fileData['enabled'] === 'true'
            );

        }
        // Create Job object out of it and add to Jobs[]
        return $jobs;
    }

    private static function jobIsActive(array $fileData): bool
    {
        return $fileData['enabled'] === 'true';
    }

}