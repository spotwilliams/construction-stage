<?php

declare(strict_types=1);

namespace ConstructionStages\Validation\Rules;

use ConstructionStages\Validation\ValidationFailed;
use ConstructionStages\Validation\ValidationRule;

class Required implements ValidationRule
{
    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        if ($value !== null) {
            return true;
        }
        throw new ValidationFailed("The field `{$field}` is required.");
    }
}
