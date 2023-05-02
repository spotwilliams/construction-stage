<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\Enums\ConstructionStageStatus;
use ConstructionStages\Enums\DurationUnit;
use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;
use ConstructionStages\Validation\ValidationFailed;

class CreateConstructionStage implements ActionContract
{
    use RequiresRepository;
    use RequireReturnsResponses;

    public function execute(Request $request): Response
    {
        $rules = [
            'name' => ['required', 'string_length' => 255],
            'startDate' => ['required', 'datetime_iso'],
            'endDate' => ['nullable', 'datetime_iso', 'later_than_datetime_iso' => $request->get('startDate')],
            'durationUnit' => ['required', 'in' => DurationUnit::toArray()],
            'color' => ['required', 'hex_color'],
            'externalId' => ['nullable', 'string_length' => 255],
            'status' => ['required', 'in' => ConstructionStageStatus::toArray()],
        ];


        try {
            $request->validate($rules);

            $model = $this->repository->store(
                new ConstructionStagesCreate($request)
            );
            return $this->response($model->toArray(), 200);
        } catch (ValidationFailed $e) {
            return $this->response(['error' => $e->getMessage()], 422);
        }
    }
}
