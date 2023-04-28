<?php

declare(strict_types=1);

namespace ConstructionStages\Repositories;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
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

    public function update(Model $model): array
    {
        // TODO: Implement update() method.
    }

    public function getModelClass(): string
    {
        return ConstructionStage::class;
    }

    public function store(ConstructionStagesCreate $data): array
    {
        return $this->queryInsert(
            query: "
			INSERT INTO construction_stages
			    (name, start_date, end_date, duration, durationUnit, color, externalId, status)
			    VALUES (:name, :start_date, :end_date, :duration, :durationUnit, :color, :externalId, :status)
			",
            bindings: [
                'name' => $data->name,
                'start_date' => $data->startDate,
                'end_date' => $data->endDate,
                'duration' => $data->duration,
                'durationUnit' => $data->durationUnit,
                'color' => $data->color,
                'externalId' => $data->externalId,
                'status' => $data->status,
            ]);
    }

    public function patch($id, ConstructionStagesUpdate $data)
    {
        $stmt = $this->db->prepare("
			UPDATE construction_stages SET
			    (name, start_date, end_date, duration, durationUnit, color, externalId, status)
			    VALUES (:name, :start_date, :end_date, :duration, :durationUnit, :color, :externalId, :status)
			");
        $stmt->execute([
            'name' => $data->name,
            'start_date' => $data->startDate,
            'end_date' => $data->endDate,
            'duration' => $data->duration,
            'durationUnit' => $data->durationUnit,
            'color' => $data->color,
            'externalId' => $data->externalId,
            'status' => $data->status,
        ]);
        return $this->getSingle($this->db->lastInsertId());
    }

    public function getSingle(int $id): array
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
			WHERE ID = :id
		", ['id' => $id]);
    }
}
