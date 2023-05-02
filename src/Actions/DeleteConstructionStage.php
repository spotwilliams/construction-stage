<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;

class DeleteConstructionStage implements ActionContract
{
    use RequiresRepository;

    public function execute(Request $request): Response
    {
        $model = $this->repository->getSingle((int) $request->getRouteParam(0));

        $deleted = $this->repository->delete($model);

        return new Response([
            'id' => $deleted->id,
            'statues' => $deleted->status,
        ]);
    }

}
