<?php

declare(strict_types=1);

namespace ConstructionStages\Http;

use ConstructionStages\Validation\Validator;

class Request
{
    private Validator $validator;

    /**
     * Create a new request instance.
     *
     * @param array $params The request parameters.
     */
    public function __construct(protected array $params)
    {
        $this->validator = new Validator();
    }

    /**
     * Get the value of the given input name from the request body.
     *
     * @param string $inputName The name of the input to retrieve.
     *
     * @return mixed|null The value of the input, or null if it is not set.
     */
    public function get(string $inputName): mixed
    {
        return $this->params['bodyParam'][$inputName] ?? null;
    }

    /**
     * Get the value of the route parameter at the given position.
     *
     * @param int $position The position of the route parameter to retrieve.
     *
     * @return mixed|null The value of the route parameter, or null if it is not set.
     */
    public function getRouteParam(int $position): mixed
    {
        return $this->params['routeParam'][$position] ?? null;
    }

    /**
     * Get all inputs from the request body.
     *
     * @return array An array containing all input values from the request body.
     */
    public function allInputs()
    {
        return $this->params['bodyParam'] ?? [];
    }

    /**
     * Validate the request inputs using the given rules.
     *
     * @param array $rules An array of validation rules to apply.
     *
     * @return bool True if all inputs pass validation, false otherwise.
     */
    public function validate(array $rules): bool
    {
        return $this->validator->validate(
            values: $this->allInputs(),
            rules: $rules,
        );
    }
}
