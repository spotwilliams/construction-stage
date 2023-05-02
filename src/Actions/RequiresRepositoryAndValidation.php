<?php

declare(strict_types=1);

namespace ConstructionStages\Actions;

use ConstructionStages\Repositories\ConstructionStageRepository;
use ConstructionStages\Validation\Validator;

trait RequiresRepositoryAndValidation
{
    private ConstructionStageRepository $repository;
    private Validator $validator;

    public function __construct()
    {
        $this->repository = new ConstructionStageRepository();
        $this->validator = new Validator();

    }
}
