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

public function selectAll($table, $inicio = null, $rows_count = null)
{
    $sql = "select * from {$table}";

    if (is_numeric($inicio) && is_numeric($rows_count) && $rows_count > 0) {
        $sql .= " LIMIT {$inicio}, {$rows_count}";
    }

    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS);

    } catch (\Exception $e) {
        die($e->getMessage());
    }
}
    public function countAll($table)
    {
        $sql = "select COUNT(*) from {$table}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return intval($stmt->fetch(PDO::FETCH_NUM)[0]);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
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

    public function delete($table, $id)
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s',
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

    public function selectOne($table, $id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE id=:id LIMIT 1', $table);

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(\PDO::FETCH_CLASS);
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

    public function selectAllComentariosComNomes()
    {
        $sql = "SELECT comentarios.id, comentarios.id_usuario, comentarios.id_post, comentarios.comentario, usuarios.nome AS nome_usuario 
            FROM comentarios 
            JOIN usuarios ON comentarios.id_usuario = usuarios.id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("Erro ao buscar comentários: " . $e->getMessage());
        }
    }
}