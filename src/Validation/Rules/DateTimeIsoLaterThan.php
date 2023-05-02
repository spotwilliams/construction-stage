<?php

declare(strict_types=1);

namespace ConstructionStages\Validation\Rules;

use ConstructionStages\Validation\ValidationFailed;
use ConstructionStages\Validation\ValidationRule;

class DateTimeIsoLaterThan implements ValidationRule
{
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        $format = 'Y-m-d\TH:i:s\Z';
        $laterThan = \DateTime::createFromFormat($format, $constraint);

        $date = \DateTime::createFromFormat($format, $value);

        if ($laterThan < $date) {
            return true;
        }

        throw new ValidationFailed("The value for field `{$field}` is not later than: {$constraint}");
    }
}
