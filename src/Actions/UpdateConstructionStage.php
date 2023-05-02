<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\DataTransfers\ConstructionStagesUpdate;
use ConstructionStages\Enums\ConstructionStageStatus;
use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;
use ConstructionStages\Repositories\ModelNotFound;
use ConstructionStages\Validation\ValidationFailed;

class UpdateConstructionStage implements ActionContract
{
    use RequiresRepository;
    use RequireReturnsResponses;

    public function execute(Request $request): Response
    {
        try {
            $request->validate([
                'status' => ['in' => ConstructionStageStatus::toArray()]
            ]);

            $model = $this->repository->getSingle(
                id: (int)$request->getRouteParam(0),
                throwNotFound: true
            );

            $constructionStage = $this->repository->update(
                model: $model,
                data: new ConstructionStagesUpdate($request)
            );

            return $this->response([$constructionStage], 200);

        } catch (ModelNotFound $e) {
            return new Response(['error' => 'construction stage not found']);
        } catch (ValidationFailed $e) {
            return $this->response(['error' => $e->getMessage()], 422);
        }
    }
}
