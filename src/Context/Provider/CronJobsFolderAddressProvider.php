<?php

declare(strict_types=1);

namespace App\Context\Provider;

class CronJobsFolderAddressProvider
{
    public static function value(): string
    {
        return realpath(__DIR__ . '../../../..') . 'config/cronjobs';
    }

}