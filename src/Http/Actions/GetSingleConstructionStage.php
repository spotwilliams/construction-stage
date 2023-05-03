<?php

declare(strict_types=1);

namespace ConstructionStages\Http\Actions;

use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\RequiresRepository;
use ConstructionStages\Http\Response;

class GetSingleConstructionStage implements ActionContract
{
    use RequiresRepository;

    public function execute(Request $request): Response
    {
        return new Response(
            $this->repository->getSingle((int)$request->getRouteParam(0))
        );
    }
}
