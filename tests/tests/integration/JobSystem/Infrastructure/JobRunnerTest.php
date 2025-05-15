<?php

namespace App\Tests\tests\integration\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Infrastructure\JobRunner;
use App\Tests\Support\IntegrationTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class JobRunnerTest extends IntegrationTestCase
{
    public function testItReturnsSuccessfulResult(): void
    {
        $mockResponse = new MockResponse('{"ok": true}', [
            'http_code' => 200,
            'response_headers' => ['Content-Type' => 'application/json'],
        ]);

        $client = new MockHttpClient($mockResponse);
        $runner = new JobRunner($client);
        $job = $this->createSampleJob();
        $result = $runner->run($job);

        $this->assertTrue($result->jobSuccessState->value);
        $this->assertEquals(200, $result->jobStatusCode->value);
    }

    private function createSampleJob(): Job
    {
        return Job::new(
            jobName: 'Test Job',
            jobSchedule: '* * * * *',
            jobUrl: 'http://example.com',
            jobMethod: 'POST',
            jobHeaders: ['Content-Type' => 'application/json'],
            jobPayload: ['foo' => 'bar'],
            jobActiveState: true
        );
    }
}