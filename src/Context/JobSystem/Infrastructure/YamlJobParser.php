<?php

namespace App\Context\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Jobs;

class YamlJobParser
{
    public function parse(): Jobs
    {
        // set empty list of jobs
        // create instance of finder
        // finder -> files -> in  pass folder address  -> name *.yaml
        // for each finder (will actually host a list now) as file:
        // data =   yaml parsefile  pass in file->getRealPath()
        // see if it is enabled. if not enabled (continue)...
        // Create Job object out of it and add to Jobs[]
        // return Jobs[]
    }

}