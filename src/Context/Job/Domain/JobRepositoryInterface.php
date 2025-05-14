<?php

namespace App\Context\Job\Domain;

interface JobRepositoryInterface
{
    public function save(JobDefinition $job): void;
}
