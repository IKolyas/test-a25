<?php

namespace models\repositories;

use database\DataBase;

abstract class Repository
{
    protected DataBase $dataBase;
    protected string $tableName;

    public function __construct()
    {
        $this->dataBase = new DataBase();
        $this->tableName = $this->getTableName();
    }

    public function add(array $params): int
    {
        $tableName = $this->getTableName();
        $paramsList = [];
        $col = [];
        foreach ($params as $key => $val) {
            $paramsList[":{$key}"] = $val;
            $col[] = "`{$key}`";
        }
        $paramsValue = implode(',', array_keys($paramsList));
        $col = implode(',', $col);
        $sql = "INSERT INTO {$tableName} ({$col}) VALUES ({$paramsValue})";
        return $this->save($sql, $paramsList);

    }

    private function save(string $sql, array $params = []): int
    {
        return $this->dataBase->execute($sql, $params);
    }

    abstract protected function getTableName(): string;
}