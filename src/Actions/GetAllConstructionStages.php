<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\Http\ActionContract;
use ConstructionStages\Http\Request;
use ConstructionStages\Http\Response;

class GetAllConstructionStages implements ActionContract
{
    use RequiresRepository;

    public function execute(Request $request): Response
    {
        return new Response(
            $this->repository->getAll()
        );
    }
}
