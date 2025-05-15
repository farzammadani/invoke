<?php

namespace App\Tests\tests\integration\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Infrastructure\YamlJobParser;
use App\Tests\Support\IntegrationTestCase;

class YamlJobParserTest extends IntegrationTestCase
{

    public function testItParsesYaml()
    {
        /** @var YamlJobParser $yamlParser */
        $yamlParser = $this->tester->grabService(YamlJobParser::class);
        $parseResult = $yamlParser->parse();

        /** @var Job[] $jobs */
        $jobs = $parseResult->jobs;

        $notifyJob = null;

        foreach ($jobs as $job) {
            if ($job->name->value === 'Notify') {
                $notifyJob = $job;
                break;
            }
        }

        $this->assertNotNull($notifyJob, 'Expected to find a job named "Notify".');
        $this->assertEquals('0 2 * * *', $notifyJob->schedule->value);
        $this->assertEquals('https://api.example.com/cleanup', $notifyJob->jobUrl->value);
        $this->assertTrue($notifyJob->enabled->value);
    }
}
