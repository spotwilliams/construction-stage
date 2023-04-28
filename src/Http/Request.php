<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

class Request
{
    public function __construct(protected array $params)
    {
    }

    public function get(string $inputName): mixed
    {
        return $this->params['bodyParam'][$inputName] ?? null;
    }

    public function getRouteParam(int $position): mixed
    {
        return $this->params['routeParam'][$position] ?? null;
    }

    public function validate(array $rules): void
    {
    }

    public function allInputs()
    {
        return $this->params['bodyParam'] ?? [];
    }
}
