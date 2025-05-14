<?php

declare(strict_types=1);

namespace App\Context\Job\Infrastructure;
use Symfony\Component\Yaml\Yaml;

class YamlJobLoader
{
    public function load(): array
    {
        $path = \App\Context\Provider\CronJobPathProvider::value();
        $jobs = [];
        foreach (glob($path . '/*.yaml') as $file) {
            // parse yaml save to data variable
            $data = Yaml::parseFile(filename: $file);
            // add it to list of jobs (entry)
            $jobs[] = $data;
        }

        //return the jobs
        return $jobs;
    }

}

