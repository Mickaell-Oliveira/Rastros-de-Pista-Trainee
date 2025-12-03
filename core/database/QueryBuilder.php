<?php

namespace App\Core\Database;

use PDO;
use Exception;

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

        if($inicio !== null && $rows_count > 0 ){
            $sql .= " LIMIT {$inicio}, {$rows_count}";
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function verificaLogin($email, $senha)
    {
        $sql = 'SELECT * FROM usuarios WHERE email = :email AND senha = :senha';

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email,
                'senha' => $senha
            ]);

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    } 

    public function countAll($table)
    {
        $sql = "select COUNT(*) from {$table}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_NUM);
            return $result ? intval($result[0]) : 0;

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

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = :id";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function selectOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id LIMIT 1";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_CLASS);
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

        try{
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("Erro ao buscar comentários: " . $e->getMessage());
        }
    }

    public function selectComentariosPorPost($postId)
    {
        $sql = "SELECT comentarios.id, comentarios.id_usuario, comentarios.id_post, comentarios.comentario, usuarios.nome AS nome_usuario 
                FROM comentarios 
                JOIN usuarios ON comentarios.id_usuario = usuarios.id
                WHERE comentarios.id_post = :post_id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute(['post_id' => $postId]);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }
}
?>