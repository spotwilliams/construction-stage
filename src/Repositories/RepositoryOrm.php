<?php

declare(strict_types=1);

namespace ConstructionStages\Repositories;

use ConstructionStages\Models\Model;

abstract class RepositoryOrm implements Repository
{
    protected static \PDO $db;

    public function __construct()
    {
        self::$db = (new Database())->init();
    }

    protected function saveModel(Model $model): Model
    {
        ['query' => $query, 'bindings' => $bindings] = $this->buildInsertQueryWithBindings($model);

        $stmt = self::$db->prepare($query);

        $stmt->execute([...$bindings]);

        return $this->getSingle((int)self::$db->lastInsertId());
    }


    protected function updateByModel(Model $model, array $data): Model
    {
        ['query' => $query, 'bindings' => $bindings] = $this->buildUpdateQueryWithBindings($model, $data);

        $stmt = self::$db->prepare($query);

        $stmt->execute([...$bindings, ':id' => $model->getIdentifier()]);

        return $this->getSingle($model->getIdentifier());
    }

    protected function querySelect(string $query, array $bindings = []): array|Model|null
    {
        $stmt = self::$db->prepare($query);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->getModelClass());
    }

    protected function queryInsert(string $query, array $bindings = []): array|Model|null
    {
        $stmt = self::$db->prepare($query);
        $stmt->execute($bindings);

        return $this->getSingle((int)self::$db->lastInsertId());
    }

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
            'query' => "INSERT INTO {$model->table} ({$columnNames}) VALUES ({$values});" ,
            'bindings' => $bindings,
        ];
    }

}
