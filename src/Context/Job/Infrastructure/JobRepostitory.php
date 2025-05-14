<?php

namespace App\Context\Job\Infrastructure;

use App\Context\Job\Domain\JobDefinition;
use App\Context\Job\Domain\JobRepositoryInterface;

class JobRepostitory implements JobRepositoryInterface
{
    public function save(JobDefinition $job): void
    {
        // TODO: Implement save() method.

    }
}