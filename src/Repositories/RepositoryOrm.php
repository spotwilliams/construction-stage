<?php

declare(strict_types=1);

namespace ConstructionStages\Repositories;

use ConstructionStages\Models\Model;

abstract class RepositoryOrm implements Repository
{
    protected static \PDO $db;

    /**
     * Create a new RepositoryOrm instance.
     *
     * @return void
     */
    public function __construct()
    {
        self::$db = (new Database())->init();
    }

    /**
     * Saves a model instance to the database.
     *
     * @param Model $model The model instance to save.
     *
     * @return Model The saved model instance.
     */
    protected function saveModel(Model $model): Model
    {
        ['query' => $query, 'bindings' => $bindings] = $this->buildInsertQueryWithBindings($model);

        $stmt = self::$db->prepare($query);

        $stmt->execute([...$bindings]);

        return $this->getSingle((int)self::$db->lastInsertId());
    }

    /**
     * Updates a model instance in the database.
     *
     * @param Model $model The model instance to update.
     * @param array $data The data to update the model with.
     *
     * @return Model The updated model instance.
     */
    protected function updateByModel(Model $model, array $data): Model
    {
        ['query' => $query, 'bindings' => $bindings] = $this->buildUpdateQueryWithBindings($model, $data);

        $stmt = self::$db->prepare($query);

        $stmt->execute([...$bindings, ':id' => $model->getIdentifier()]);

        return $this->getSingle($model->getIdentifier());
    }

    /**
     * Executes a SELECT query against the database and returns the result as an array of Model instances.
     *
     * @param string $query The SELECT query to execute.
     * @param array $bindings The parameter bindings for the query.
     *
     * @return array|Model|null The result set as an array of Model instances, or a single Model instance, or null if no results were found.
     */
    protected function querySelect(string $query, array $bindings = []): array|Model|null
    {
        $stmt = self::$db->prepare($query);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->getModelClass());
    }

    /**
     * Builds an UPDATE query string and parameter bindings based on the given model instance and data.
     *
     * @param Model $model The model instance to update.
     * @param array $data The data to update the model with.
     *
     * @return array An associative array containing the 'query' and 'bindings' keys for the UPDATE query string and parameter bindings, respectively.
     */
    private function buildUpdateQueryWithBindings(Model $model, array $data): array
    {
        $baseQuery = "UPDATE {$model->table} SET ";
        $bindings = [];

        $partial = '';
        foreach ($model->attributes as $attribute) {
            if (isset($data[$attribute])) {
                $partial .= "$attribute = :{$attribute},";
                $bindings[":{$attribute}"] = $data[$attribute];
            }
        }

        $partial = trim($partial, ',');

        return [
            'query' => $baseQuery . $partial . " WHERE id = :id",
            'bindings' => $bindings,
        ];
    }

    /**
     * Builds an INSERT query string and parameter bindings based on the given model instance.
     *
     * @param Model $model The model instance to insert.
     *
     * @return array An associative array containing the 'query' and 'bindings' keys for the INSERT query string and parameter bindings, respectively.
     */
    private function buildInsertQueryWithBindings(Model $model): array
    {
        $columnNames = '';
        $bindings = [];

        $values = '';
        foreach ($model->attributes as $attribute) {
            if (isset($model->{$attribute})) {
                $columnNames .= "{$attribute},";

                $values .= ":{$attribute},";
                $bindings[":{$attribute}"] = $model->{$attribute};
            }
        }

        $values = trim($values, ',');
        $columnNames = trim($columnNames, ',');

        return [
            'query' => "INSERT INTO {$model->table} ({$columnNames}) VALUES ({$values});",
            'bindings' => $bindings,
        ];
    }

}
