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
    /** @inheritDoc */
    public function getAll(): array
    {
        return $this->querySelect("
			SELECT
				ID as id,
				name, 
				strftime('%Y-%m-%dT%H:%M:%SZ', startDate) as startDate,
				strftime('%Y-%m-%dT%H:%M:%SZ', endDate) as endDate,
				duration,
				durationUnit,
				color,
				externalId,
				status
			FROM construction_stages
		");
    }

    /** @inheritDoc */
    public function update(Model $model, ConstructionStagesUpdate $data): Model
    {
        return $this->updateByModel($model, $data->toArray());
    }

    /** @inheritDoc */
    public function getModelClass(): string
    {
        return ConstructionStage::class;
    }

    /** @inheritDoc */
    public function store(ConstructionStagesCreate $data): Model
    {
        $model = new ConstructionStage([
            'name' => $data->name,
            'startDate' => $data->startDate,
            'endDate' => $data->endDate,
            'duration' => $data->duration,
            'durationUnit' => $data->durationUnit,
            'color' => $data->color,
            'externalId' => $data->externalId,
            'status' => $data->status,
        ]);

        return $this->saveModel($model);
    }

    /** @inheritDoc */
    public function getSingle(int $id, bool $throwNotFound = false): ?Model
    {
        $result = current(
            $this->querySelect("
			SELECT
				ID as id,
				name, 
				strftime('%Y-%m-%dT%H:%M:%SZ', startDate) as startDate,
				strftime('%Y-%m-%dT%H:%M:%SZ', endDate) as endDate,
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

    /** @inheritDoc */
    public function delete(Model $model): Model
    {
        return $this->updateByModel($model, ['status' => ConstructionStageStatus::DELETED->name]);
    }
}
