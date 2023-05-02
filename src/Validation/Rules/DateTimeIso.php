<?php

declare(strict_types=1);

namespace ConstructionStages\Validation\Rules;

use ConstructionStages\Validation\ValidationFailed;
use ConstructionStages\Validation\ValidationRule;

class DateTimeIso implements ValidationRule
{
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        $format = 'Y-m-d\TH:i:s\Z';
        $datetime = \DateTime::createFromFormat($format, $value);

        if ($datetime && $datetime->format($format) === $value) {
            return true;
        }
        throw new ValidationFailed("The value for field `{$field}`is not a valid ISO format Date & time.");
    }
}
