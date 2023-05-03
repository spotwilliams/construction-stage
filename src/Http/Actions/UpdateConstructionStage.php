<?php

declare(strict_types=1);

namespace ConstructionStages\Http\Actions;

use ConstructionStages\DataTransfers\ConstructionStagesUpdate;
use ConstructionStages\Enums\ConstructionStageStatus;
use ConstructionStages\Enums\DurationUnit;
use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\RequireReturnsResponses;
use ConstructionStages\Http\RequiresRepository;
use ConstructionStages\Http\Response;
use ConstructionStages\Repositories\ModelNotFound;
use ConstructionStages\Services\UpdateConstructionStageService;
use ConstructionStages\Validation\ValidationFailed;

class UpdateConstructionStage implements ActionContract
{
    use RequiresRepository;
    use RequireReturnsResponses;

    /** @inheritDoc */
    public function execute(Request $request): Response
    {

        try {
            $model = $this->repository->getSingle(id: (int)$request->getRouteParam(0), throwNotFound: true);

            $rules = [
                'name' => ['nullable', 'string_length' => 255],
                'startDate' => ['nullable', 'datetime_iso'],
                'endDate' => ['nullable', 'datetime_iso', 'later_than_datetime_iso' => $request->get('startDate') ?? $model->startDate],
                'durationUnit' => ['nullable', 'in' => DurationUnit::toArray()],
                'color' => ['nullable', 'hex_color'],
                'externalId' => ['nullable', 'string_length' => 255],
                'status' => ['nullable', 'in' => ConstructionStageStatus::toArray()],
            ];

            $request->validate($rules);
            $service = new UpdateConstructionStageService();

            $constructionStage = $service->execute(new ConstructionStagesUpdate($request), $model);

            return $this->response([$constructionStage], 200);

        } catch (ModelNotFound $e) {
            return new Response(['error' => 'construction stage not found']);
        } catch (ValidationFailed $e) {
            return $this->response(['error' => $e->getMessage()], 422);
        } catch (\InvalidArgumentException $e) {
            return $this->response(['error' => $e->getMessage()], 422);

        }
    }
}
