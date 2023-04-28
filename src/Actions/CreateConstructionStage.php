<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;

class CreateConstructionStage implements ActionContract
{
    use RequiresRepository;

    public function execute(Request $request): Response
    {
        $request->validate([]);

        return new Response(
            $this->repository->store(
                new ConstructionStagesCreate($request)
            )
        );
    }
}
