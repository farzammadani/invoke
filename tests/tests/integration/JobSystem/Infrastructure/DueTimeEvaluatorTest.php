<?php

namespace App\Tests\tests\integration\JobSystem\Infrastructure;

use App\Context\JobSystem\Domain\Job;
use App\Context\JobSystem\Infrastructure\DueTimeEvaluator;
use App\Tests\Support\IntegrationTestCase;

class DueTimeEvaluatorTest extends IntegrationTestCase
{
    public static function dataProvider(): array
    {
        return [
            'It evaluates to false if due time is not matching' => [
                'matchDueTime' => false,
                'expectedResult' => false
            ],
            'It evaluates to true if due time is matching' => [
                'matchDueTime' => true,
                'expectedResult' => true
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testItEvaluatesCorrectly(bool $matchDueTime, bool $expectedResult): void
    {
        /**
         * @var DueTimeEvaluator $evaluator
         */
        $evaluator = $this->tester->grabService(DueTimeEvaluator::class);
        $now = new \DateTimeImmutable('now');
        $job = $this->createSampleJob(
            now: $now,  matchDueTime: $matchDueTime
        );
        $actualResult = $evaluator->checkIsDueNow(
            job: $job, now: $now
        );

        $this->assertEquals($expectedResult, $actualResult);
    }


    private function createSampleJob(\DateTimeImmutable $now ,bool $matchDueTime): Job
    {
        $minute = (int) $now->format('i');
        $hour = (int) $now->format('H');
        if($matchDueTime === false)
        {
            $minute = ((int) $now->format('i') + 1) % 60;
            $hour = ((int) $now->format('H') + 1) % 24;
        }

        $cronExpression = sprintf('%d %d * * *', $minute, $hour);

        $job = Job::new(
            jobName: 'Sample Job',
            jobSchedule: $cronExpression,
            jobUrl: 'https://example.org',
            jobMethod: 'POST',
            jobHeaders: [],
            jobPayload: [],
            jobActiveState: true
        );

        return $job;
    }

}