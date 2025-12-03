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

    public function verificaLogin($email, $senha)
    {
        $sql = 'SELECT * FROM usuarios WHERE email = :email AND senha = :senha';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $email, 'senha' => $senha]);
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
            return intval($stmt->fetch(PDO::FETCH_NUM)[0]);
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
        $sql = "DELETE FROM {$table} WHERE id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
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
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
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
            die($e->getMessage());
        }
    }

    public function registrarInteracao($idUsuario, $idPost, $tipoNumerico)
    {
        $tabela = 'interacoes'; 

        try {
            $this->pdo->beginTransaction();

            $sqlCheck = "SELECT tipo FROM {$tabela} WHERE id_usuario = :user AND id_post = :post";
            $stmt = $this->pdo->prepare($sqlCheck);
            $stmt->execute(['user' => $idUsuario, 'post' => $idPost]);
            $votoExistente = $stmt->fetch(PDO::FETCH_OBJ);

            $valLike = ($tipoNumerico == 1) ? 1 : 0;
            $valDislike = ($tipoNumerico == 2) ? 1 : 0;

            if ($votoExistente) {
                if ($votoExistente->tipo == $tipoNumerico) {
                    $sqlDel = "DELETE FROM {$tabela} WHERE id_usuario = :user AND id_post = :post";
                    $this->pdo->prepare($sqlDel)->execute(['user' => $idUsuario, 'post' => $idPost]);
                } else {
                    $sqlUpd = "UPDATE {$tabela} SET tipo = :t, likes = :l, dislikes = :d WHERE id_usuario = :user AND id_post = :post";
                    $this->pdo->prepare($sqlUpd)->execute([
                        't' => $tipoNumerico,
                        'l' => $valLike,
                        'd' => $valDislike,
                        'user' => $idUsuario,
                        'post' => $idPost
                    ]);
                }
            } else {
                $sqlIns = "INSERT INTO {$tabela} (id_usuario, id_post, tipo, likes, dislikes) VALUES (:user, :post, :t, :l, :d)";
                $this->pdo->prepare($sqlIns)->execute([
                    'user' => $idUsuario,
                    'post' => $idPost,
                    't' => $tipoNumerico,
                    'l' => $valLike,
                    'd' => $valDislike
                ]);
            }

            $this->atualizarContadoresPost($idPost, $tabela);
            
            $this->pdo->commit();
            return $this->selectById('posts', $idPost);

        } catch (Exception $e) {
            $this->pdo->rollBack();
            die(json_encode(['erro' => $e->getMessage()])); 
        }
    }

    private function atualizarContadoresPost($idPost, $tabelaInteracoes)
    {
        $stmtLike = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabelaInteracoes} WHERE id_post = ? AND tipo = 1");
        $stmtLike->execute([$idPost]);
        $likes = $stmtLike->fetchColumn();

        $stmtDislike = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabelaInteracoes} WHERE id_post = ? AND tipo = 2");
        $stmtDislike->execute([$idPost]);
        $dislikes = $stmtDislike->fetchColumn();

        $sql = "UPDATE posts SET likes = :l, dislikes = :d WHERE id = :id";
        $this->pdo->prepare($sql)->execute(['l' => $likes, 'd' => $dislikes, 'id' => $idPost]);
    }
}
?>