<?php

namespace App\Tests\Support;

use Codeception\Test\Unit;
use Tests\Support\IntegrationTester;

/**
 * Base test case for integration tests with access to grabService via $this->tester
 */
abstract class IntegrationTestCase extends Unit
{
    protected IntegrationTester $tester;
}
