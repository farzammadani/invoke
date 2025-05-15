<?php

namespace App\Context\JobSystem\Infrastructure;

use RuntimeException;

class CronjobEnvPlaceholderSubstitutor
{
    public static function substitute(array $fileData): array
    {
        foreach ($fileData as $key => $value) {
            if (is_array($value)) {
                // Recursively resolve nested arrays
                $fileData[$key] = self::substitute($value);

                // Check for env reference at this level
                if (isset($value['env']['valueFrom'])) {
                    $providerClass = $value['env']['valueFrom'];

                    if (!class_exists($providerClass)) {
                        throw new RuntimeException("Provider class not found: $providerClass");
                    }

                    if (!method_exists($providerClass, 'value')) {
                        throw new RuntimeException("Provider class $providerClass must have a static method 'value'");
                    }

                    $fileData[$key] = $providerClass::value();
                }
            }
        }

        return $fileData;
    }

}