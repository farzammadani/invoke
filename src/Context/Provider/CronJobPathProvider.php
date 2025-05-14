<?php

namespace App\Context\Provider;

class CronJobPathProvider
{
    public static function value(): string
    {
        return dirname(__DIR__, 3) . '/config/cronjobs';
    }
}