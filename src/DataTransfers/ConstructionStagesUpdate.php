<?php

namespace ConstructionStages\DataTransfers;

use ConstructionStages\Http\Request;

class ConstructionStagesUpdate
{
    private array $values = [];

    public function __construct(Request $request)
    {
        foreach ($request->allInputs() as $name => $value) {
            $this->$name = $value;
            $this->values[$name] = $value;
        }
    }

    public function toArray(): array
    {
        return $this->values;
    }
}