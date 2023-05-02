<?php

declare(strict_types=1);

namespace ConstructionStages\Validation\Rules;

use ConstructionStages\Validation\ValidationFailed;
use ConstructionStages\Validation\ValidationRule;

class In implements ValidationRule
{
    public function apply(string $ruleName, array|string $constraints, string $field, mixed $value): bool
    {
        if (in_array($value, $constraints)) return true;

        throw new ValidationFailed("The value for field `{$field}`is not in the required list: " . implode(',', $constraints));
    }

}
