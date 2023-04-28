<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\Repositories\ConstructionStageRepository;

trait RequiresRepository
{
    private ConstructionStageRepository $repository;

    public function __construct()
    {
        $this->repository = new ConstructionStageRepository();
    }
}
