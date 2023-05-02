<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;

class CreateConstructionStage implements ActionContract
{
    use RequiresRepositoryAndValidation;

    public function execute(Request $request): Response
    {
        $request->validate([]);

        $model =  $this->repository->store(
            new ConstructionStagesCreate($request)
        );
        return new Response(
           $model->toArray()
        );
    }
}
