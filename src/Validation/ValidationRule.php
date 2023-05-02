<?php

namespace ConstructionStages\Validation;

interface ValidationRule
{
    /** @throws ValidationFailed */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool;
}