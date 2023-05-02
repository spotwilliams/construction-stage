<?php

namespace ConstructionStages\Validation;

interface ValidationRule
{
    /** @throws ValidationFailed */
    public function apply(string $ruleName, array|string $constraints, string $field, mixed $value): bool;
}