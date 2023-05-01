<?php

declare(strict_types=1);

namespace ConstructionStages\Repositories;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\DataTransfers\ConstructionStagesUpdate;
use ConstructionStages\Enums\ConstructionStageStatus;
use ConstructionStages\Models\ConstructionStage;
use ConstructionStages\Models\Model;

class ConstructionStageRepository extends RepositoryOrm
{
    public function getAll(): array
    {
        return $this->querySelect("
			SELECT
				ID as id,
				name, 
				strftime('%Y-%m-%dT%H:%M:%SZ', start_date) as startDate,
				strftime('%Y-%m-%dT%H:%M:%SZ', end_date) as endDate,
				duration,
				durationUnit,
				color,
				externalId,
				status
			FROM construction_stages
		");
    }

    public function update(Model $model, ConstructionStagesUpdate $data): Model
    {
        return $this->updateByModel($model, $data->toArray());
    }

    public function getModelClass(): string
    {
        return ConstructionStage::class;
    }

    public function store(ConstructionStagesCreate $data): Model
    {
        $model = new ConstructionStage([
            'name' => $data->name,
            'start_date' => $data->startDate,
            'end_date' => $data->endDate,
            'duration' => $data->duration,
            'durationUnit' => $data->durationUnit,
            'color' => $data->color,
            'externalId' => $data->externalId,
            'status' => $data->status,
        ]);

        return $this->saveModel($model);
    }

    public function getSingle(int $id, bool $throwNotFound = false): ?Model
    {
        $result = current(
            $this->querySelect("
			SELECT
				ID as id,
				name, 
				strftime('%Y-%m-%dT%H:%M:%SZ', start_date) as startDate,
				strftime('%Y-%m-%dT%H:%M:%SZ', end_date) as endDate,
				duration,
				durationUnit,
				color,
				externalId,
				status
			FROM construction_stages
			WHERE ID = :id
		", ['id' => $id])
        );
        if ($result === false && $throwNotFound) throw new ModelNotFound();

        return $result;
    }

    public function delete(Model $model): Model
    {
        return $this->updateByModel($model, ['status' => ConstructionStageStatus::DELETED->name]);
    }
}
