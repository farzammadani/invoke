<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Domain\Jobs;
use App\Context\Provider\CronJobsFolderAddressProvider;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

final class YamlJobParser
{
    public function __construct(
        private readonly CronjobEnvPlaceholderSubstitutor $substitutor
    ) {}

    /**
     * Parses all YAML files found in the cron job folder and converts them into Job objects.
     * Environment placeholders (e.g., tokens, secrets) are resolved via the CronjobEnvPlaceholderSubstitutor.
     *
     * @return Jobs Parsed list of active jobs.
     */
    public function parse(): Jobs
    {
        // Initialize an empty list of jobs
        $jobs = [];

        // Use Symfony Finder to locate all YAML files in the cron job folder
        $finder = new Finder();
        $finder->files()
            ->in(CronJobsFolderAddressProvider::value())
            ->name('*.yaml');

        // Process each YAML file
        foreach ($finder as $file) {
            // Parse the file into an associative array
            $fileData = Yaml::parseFile($file->getRealPath());

            // Skip the job if it's not explicitly enabled
            if (!self::jobIsActive($fileData)) {
                continue;
            }

            // Recursively replace any environment references (valueFrom)
            $fileData = $this->substitutor->substitute($fileData);

            // Create a Job object from the parsed data and add it to the list
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

        // Wrap and return all created Job objects in a Jobs value object
        return Jobs::new(jobs: $jobs);
    }

    /**
     * Checks if the job is marked as enabled.
     *
     * @param array $fileData Parsed YAML file content
     * @return bool True if the job is enabled
     */
    private static function jobIsActive(array $fileData): bool
    {
        return $fileData['enabled'] === true;
    }
}
