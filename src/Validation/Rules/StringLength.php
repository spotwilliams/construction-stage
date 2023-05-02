<?php

declare(strict_types=1);

namespace ConstructionStages\Validation\Rules;

use ConstructionStages\Validation\ValidationFailed;
use ConstructionStages\Validation\ValidationRule;

class StringLength implements ValidationRule
{
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        if (strlen($value) <= (int)$constraint) {
            return true;
        }
        throw new ValidationFailed("The value for field `{$field}` has a length greater than {$constraint}.");
    }
}
