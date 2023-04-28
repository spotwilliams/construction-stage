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
}
