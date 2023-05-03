<?php

declare(strict_types=1);

namespace ConstructionStages\Validation\Rules;

use ConstructionStages\Validation\SkipNextRules;
use ConstructionStages\Validation\ValidationRule;

class Nullable implements ValidationRule
{
    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        if ($value === null) {
            throw new SkipNextRules();
        }

        return true;
    }
}
