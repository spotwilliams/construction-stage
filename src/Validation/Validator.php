<?php

declare(strict_types=1);

namespace ConstructionStages\Validation;

use ConstructionStages\Validation\Rules\In;

class Validator
{
    private $rules = [
        'in' => In::class
    ];

    /** @throws ValidationFailed */
    public function validate(array $values, array $rules): bool
    {
        foreach ($rules as $inputName => $constraints) {
            foreach ($constraints as $rule => $constraint) {
                $this->findRule($rule)->apply(
                    ruleName: $rule,
                    constraints: $constraint,
                    field: $inputName,
                    value: $values[$inputName]
                );
            }
        }

        return true;
    }

    private function findRule(string $name): ValidationRule
    {
        if (isset($this->rules[$name])) {
            return new  $this->rules[$name];
        }
        throw new \Exception('validation rule not found');
    }

}
