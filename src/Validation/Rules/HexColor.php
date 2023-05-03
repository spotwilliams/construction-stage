<?php

declare(strict_types=1);

namespace ConstructionStages\Validation\Rules;

use ConstructionStages\Validation\ValidationFailed;
use ConstructionStages\Validation\ValidationRule;

class HexColor implements ValidationRule
{
    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        if (preg_match('/^#[0-9A-Fa-f]{6}$/', $value)) {
            return true;
        }

        throw new ValidationFailed("The value for field `{$field}` is not a valid HEX color.");
    }
}
