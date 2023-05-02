<?php

declare(strict_types=1);

namespace ConstructionStages\Validation;

use ConstructionStages\Validation\Rules;

class Validator
{
    private $rules = [
        'datetime_iso' => Rules\DateTimeIso::class,
        'later_than_datetime_iso' => Rules\DateTimeIsoLaterThan::class,
        'hex_color' => Rules\HexColor::class,
        'in' => Rules\In::class,
        'nullable' => Rules\Nullable::class,
        'required' => Rules\Required::class,
        'string_length' => Rules\StringLength::class,
    ];

    /** @throws ValidationFailed */
    public function validate(array $values, array $rules): bool
    {
        foreach ($rules as $inputName => $constraints) {
            foreach ($constraints as $rule => $constraintOrName) {

                $ruleName = is_string($rule) ? $rule : $constraintOrName;
                $constraint = is_string($rule) ? $constraintOrName : null;
                try {
                    $this->findRule($ruleName)->apply(
                        ruleName: $ruleName,
                        field: $inputName,
                        value: $values[$inputName] ?? null,
                        constraint: $constraint
                    );
                } catch (SkipNextRules $e) {
                    continue 2;
                }
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
