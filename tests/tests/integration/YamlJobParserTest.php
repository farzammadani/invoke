<?php

namespace App\Tests\tests\integration;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Infrastructure\YamlJobParser;
use App\Tests\Support\IntegrationTestCase;

class YamlJobParserTest extends IntegrationTestCase
{

    public function testItParsesYaml()
    {
        /**
         * @var YamlJobParser $yamlParser
         */
        $yamlParser = $this->tester->grabService(YamlJobParser::class);
        $parseResult = $yamlParser->parse();
        /**
         * @var Job[] $jobs
         */
        $jobs = $parseResult->jobs;
        $firstJob = $jobs[0];
        $this->assertEquals($firstJob->name->value, 'Notify');
        $this->assertEquals($firstJob->schedule->value, '0 2 * * *');
        $this->assertEquals($firstJob->enabled->value, true);
    }
}
