<?php

namespace ConstructionStages\DataTransfers;

use ConstructionStages\Http\Request;

class ConstructionStagesCreate
{
    public $name;
    public $startDate;
    public $endDate;
    public $duration;
    public $durationUnit;
    public $color;
    public $externalId;
    public $status;

    public function __construct(Request $request)
    {
        foreach ($request->allInputs() as $name => $value) {
            $this->$name = $value;
        }
    }
}