<?php

declare(strict_types=1);

namespace ConstructionStages\Services;

use ConstructionStages\DataTransfers\ConstructionStagesUpdate;
use ConstructionStages\DateTime;
use ConstructionStages\Enums\DurationUnit;
use ConstructionStages\Http\RequiresRepository;
use ConstructionStages\Models\Model;
use ConstructionStages\Services\DurationCalculators\DurationCalculationService;

class UpdateConstructionStageService
{
    use RequiresRepository;

    /**
     * Updates a construction stage with the given payload and model
     *
     * @param ConstructionStagesUpdate $payload The update payload
     * @param Model $model The model to update
     * @return Model The updated model
     * @throws \InvalidArgumentException If the construction stage doesn't have a valid duration unit
     */
    public function execute(ConstructionStagesUpdate $payload, Model $model): Model
    {
        if ($payload->endDate ?? null) {

            if(($payload->durationUnit ?? null) === null && $model->durationUnit === null) {
                throw new \InvalidArgumentException("This construction stage doesnt have a valid `Duration Unit`");
            }

            $payload->duration = DurationCalculationService::calculate(
                DateTime::createFromIsoFormat($payload->startDate ?? $model->startDate),
                DateTime::createFromIsoFormat($payload->endDate),
                DurationUnit::createFrom($payload->durationUnit ?? $model->durationUnit),
            );
        }
        return $this->repository->update(
            model: $model,
            data: $payload
        );

    }
}
