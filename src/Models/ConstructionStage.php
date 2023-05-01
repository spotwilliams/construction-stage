<?php

declare(strict_types=1);

namespace ConstructionStages\Models;

class ConstructionStage extends Model
{
    public $table = 'construction_stages';

    public $attributes = [
        'name',
        'start_date',
        'color',
        'name',
        'end_date',
        'duration',
        'durationUnit',
        'color',
        'externalId',
        'status',
    ];
}
