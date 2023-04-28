<?php

namespace ConstructionStages\Repositories;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\Models\Model;

interface Repository
{
    public function getAll(): array;

    public function getSingle(int $id): array;

    public function store(ConstructionStagesCreate $data): array;

    public function update(Model $model): array;

    public function getModelClass(): string;
}