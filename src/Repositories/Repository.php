<?php

namespace ConstructionStages\Repositories;

use ConstructionStages\DataTransfers\ConstructionStagesCreate;
use ConstructionStages\DataTransfers\ConstructionStagesUpdate;
use ConstructionStages\Models\Model;

interface Repository
{
    /**
     * Returns an array of all ConstructionStages.
     *
     * @return array An array of ConstructionStages.
     */
    public function getAll(): array;

    /**
     * Returns a single ConstructionStage by its ID.
     *
     * @param int $id The ID of the ConstructionStage to retrieve.
     * @param bool $throwNotFound Whether to throw a ModelNotFound exception if the ConstructionStage is not found.
     * @return Model|null The ConstructionStage with the given ID, or null if it is not found and $throwNotFound is false.
     * @throws ModelNotFound if $throwNotFound is true and the ConstructionStage is not found.
     */
    public function getSingle(int $id, bool $throwNotFound = false): ?Model;

    /**
     * Creates a new ConstructionStage with the given data.
     *
     * @param ConstructionStagesCreate $data The data for the new ConstructionStage.
     * @return Model The newly created ConstructionStage.
     */
    public function store(ConstructionStagesCreate $data): Model;

    /**
     * Updates the given ConstructionStage with the given data.
     *
     * @param Model $model The ConstructionStage to update.
     * @param ConstructionStagesUpdate $data The new data for the ConstructionStage.
     * @return Model The updated ConstructionStage.
     */
    public function update(Model $model, ConstructionStagesUpdate $data): Model;

    /**
     * Deletes the given ConstructionStage.
     *
     * @param Model $model The ConstructionStage to delete.
     * @return Model The deleted ConstructionStage.
     */
    public function delete(Model $model): Model;

    /**
     * Returns the class name of the Model that this repository handles.
     *
     * @return string The class name of the Model.
     */
    public function getModelClass(): string;
}
