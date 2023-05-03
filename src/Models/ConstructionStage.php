<?php

declare(strict_types=1);

namespace ConstructionStages\Models;

class ConstructionStage extends Model
{
    public $table = 'construction_stages';

    public $attributes = [
        'name',
        'startDate',
        'color',
        'name',
        'endDate',
        'duration',
        'durationUnit',
        'color',
        'externalId',
        'status',
    ];
}
