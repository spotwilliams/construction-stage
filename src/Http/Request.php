<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

use ConstructionStages\Validation\Validator;

class Request
{
    private Validator $validator;

    public function __construct(protected array $params)
    {
        $this->validator = new Validator();
    }

    public function get(string $inputName): mixed
    {
        return $this->params['bodyParam'][$inputName] ?? null;
    }

    public function getRouteParam(int $position): mixed
    {
        return $this->params['routeParam'][$position] ?? null;
    }

    public function allInputs()
    {
        return $this->params['bodyParam'] ?? [];
    }

    public function validate(array $rules): bool
    {
        return $this->validator->validate(
            values: $this->allInputs(),
            rules: $rules,
        );
    }
}
