<?php

namespace App\Core\Database;

use PDO, Exception;

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table)
    {
        $sql = "select * from {$table}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function selectById($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            return $stmt->fetch(PDO::FETCH_OBJ);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function selectWhere($table, $conditions)
    {
        $clauses = [];
        foreach ($conditions as $key => $value) {
            $clauses[] = "{$key} = :{$key}";
        }
        
        $sql = "SELECT * FROM {$table} WHERE " . implode(' AND ', $clauses);

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($conditions);

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($table, $id, $parameters)
    {
        $setPart = implode(', ', array_map(function ($key) {
            return "{$key} = :{$key}";
        }, array_keys($parameters)));

        $sql = "UPDATE {$table} SET {$setPart} WHERE id = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $parameters['id'] = $id;
            $stmt->execute($parameters);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function delete($table, $id)
    {
        $sql = sprintf('DELETE FROM %s WHERE %s',
            $table,
            'id = :id'
        );
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(compact('id'));

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}