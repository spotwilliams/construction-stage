<?php

namespace ConstructionStages\DataTransfers;

use ConstructionStages\Http\Request;

class ConstructionStagesUpdate
{
    public function __construct(Request $request)
    {
        foreach ($request->allInputs() as $name => $value) {
            $this->$name = $value;
        }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}