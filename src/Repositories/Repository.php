<?php

namespace ConstructionStages\Repositories;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\DataTransfers\ConstructionStagesUpdate;
use ConstructionStages\Models\Model;

interface Repository
{
    public function getAll(): array;

    public function getSingle(int $id, bool $throwNotFound = false): ?Model;

    public function store(ConstructionStagesCreate $data): Model;

    public function update(Model $model, ConstructionStagesUpdate $data): Model;

    public function delete(Model $model):Model;

    public function getModelClass(): string;
}