<?php

declare(strict_types=1);

namespace ConstructionStages\Services;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\Enums\DurationUnit;
use ConstructionStages\Http\RequiresRepository;
use ConstructionStages\Models\ConstructionStage;
use ConstructionStages\Models\Model;
use ConstructionStages\Services\DurationCalculators\DurationCalculationService;

class CreateConstructionStageService
{
    use RequiresRepository;

    /**
     * Create a new construction stage.
     *
     * @param ConstructionStagesCreate $payload The data needed to create a new construction stage.
     * @return Model The created construction stage.
     */
    public function execute(ConstructionStagesCreate $payload): Model
    {
        $format = 'Y-m-d\TH:i:s\Z';
        if ($payload->endDate) {
            $payload->duration = DurationCalculationService::calculate(
                \DateTime::createFromFormat($format, $payload->startDate),
                \DateTime::createFromFormat($format, $payload->endDate),
                DurationUnit::createFrom($payload->durationUnit),
            );
        }

        return $this->repository->store($payload);
    }
}
