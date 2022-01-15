<?php

namespace database;

use PDOException;

class DataBase
{

    private ?\PDO $connection = null;

    protected function getConnection(): ?\PDO
    {
        if (is_null($this->connection)) {
            try {
                $this->connection = new \PDO(
                    'mysql:host=localhost:3306;dbname=a0620868_test_work',
                    'a0620868_test_work',
                    'testwork',
                    [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage();
                die();
            }
        }

        return $this->connection;
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    private function query(string $sql, array $params = [])
    {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

}