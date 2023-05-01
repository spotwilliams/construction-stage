<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\DataTransfers\ConstructionStagesUpdate;
use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;
use ConstructionStages\Repositories\ModelNotFound;

class UpdateConstructionStage implements ActionContract
{
    use RequiresRepository;

    public function execute(Request $request): Response
    {
        try {

            $constructionStage = $this->repository->update(
                model: $this->repository->getSingle(
                    id: (int)$request->getRouteParam(0),
                    throwNotFound: true
                ),
                data: new ConstructionStagesUpdate($request)
            );

            return new Response([$constructionStage]);

        } catch (ModelNotFound $e) {
            return new Response(['error' => 'construction stage not found']);
        }
    }
}
