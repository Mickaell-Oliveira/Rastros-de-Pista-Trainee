<?php

namespace App\Core\Database;

use PDO;
use Exception;
use stdClass;

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table, $inicio = null, $rows_count = null)
    {
        $sql = "select * from {$table} ORDER BY id DESC";

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
        $sql = "SELECT * FROM {$table} WHERE " . implode(' AND ', $clauses) . " ORDER BY id DESC";
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
        $sql = "SELECT comentarios.id, comentarios.id_usuario, comentarios.id_post, comentarios.comentario, comentarios.data, 
                       usuarios.nome AS nome_usuario, usuarios.foto AS foto_usuario
                FROM comentarios 
                JOIN usuarios ON comentarios.id_usuario = usuarios.id
                ORDER BY comentarios.id DESC";
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
        $sql = "SELECT comentarios.id, comentarios.id_usuario, comentarios.id_post, comentarios.comentario, comentarios.data, 
                       usuarios.nome AS nome_usuario, usuarios.foto AS foto_usuario
                FROM comentarios 
                JOIN usuarios ON comentarios.id_usuario = usuarios.id
                WHERE comentarios.id_post = :post_id
                ORDER BY comentarios.id DESC";
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

            $sqlCheck = "SELECT id, tipo FROM {$tabela} WHERE id_usuario = :user AND id_post = :post";
            $stmt = $this->pdo->prepare($sqlCheck);
            $stmt->execute(['user' => $idUsuario, 'post' => $idPost]);
            $votoExistente = $stmt->fetch(PDO::FETCH_OBJ);

            if ($votoExistente) {
                if ($votoExistente->tipo == $tipoNumerico) {
                    $sqlDel = "DELETE FROM {$tabela} WHERE id = :id";
                    $this->pdo->prepare($sqlDel)->execute(['id' => $votoExistente->id]);
                } else {
                    $sqlUpd = "UPDATE {$tabela} SET tipo = :t WHERE id = :id";
                    $this->pdo->prepare($sqlUpd)->execute([
                        't' => $tipoNumerico,
                        'id' => $votoExistente->id
                    ]);
                }
            } else {
                $sqlIns = "INSERT INTO {$tabela} (id_usuario, id_post, tipo) VALUES (:user, :post, :t)";
                $this->pdo->prepare($sqlIns)->execute([
                    'user' => $idUsuario,
                    'post' => $idPost,
                    't' => $tipoNumerico
                ]);
            }

            $stmtLikes = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabela} WHERE id_post = ? AND tipo = 1");
            $stmtLikes->execute([$idPost]);
            $totalLikes = $stmtLikes->fetchColumn();

            $stmtDislikes = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabela} WHERE id_post = ? AND tipo = 2");
            $stmtDislikes->execute([$idPost]);
            $totalDislikes = $stmtDislikes->fetchColumn();
            
            $this->pdo->commit();

            $resultado = new stdClass();
            $resultado->likes = $totalLikes;
            $resultado->dislikes = $totalDislikes;
            
            return $resultado;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e; 
        }
    }

    public function buscarTotaisInteracao($idPost)
    {
        $tabela = 'interacoes';

        try {
            $stmtLikes = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabela} WHERE id_post = ? AND tipo = 1");
            $stmtLikes->execute([$idPost]);
            $totalLikes = $stmtLikes->fetchColumn();

            $stmtDislikes = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabela} WHERE id_post = ? AND tipo = 2");
            $stmtDislikes->execute([$idPost]);
            $totalDislikes = $stmtDislikes->fetchColumn();

            $resultado = new stdClass();
            $resultado->likes = $totalLikes;
            $resultado->dislikes = $totalDislikes;
            
            return $resultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function verificarVotoUsuario($idUsuario, $idPost)
    {
        $sql = "SELECT tipo FROM interacoes WHERE id_usuario = :user AND id_post = :post";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user' => $idUsuario, 'post' => $idPost]);
            return $stmt->fetchColumn(); 
        } catch (Exception $e) {
            return false;
        }
    }

    public function countComentariosPorPost($idPost)
    {
        $sql = "SELECT COUNT(*) FROM comentarios WHERE id_post = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $idPost]);
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function registrarInteracaoComentario($idUsuario, $idComentario, $tipoNumerico)
    {
        $tabela = 'interacoes_comentarios'; 

        try {
            $this->pdo->beginTransaction();

            $sqlCheck = "SELECT id, tipo FROM {$tabela} WHERE id_usuario = :user AND id_comentario = :comentario";
            $stmt = $this->pdo->prepare($sqlCheck);
            $stmt->execute(['user' => $idUsuario, 'comentario' => $idComentario]);
            $votoExistente = $stmt->fetch(PDO::FETCH_OBJ);

            if ($votoExistente) {
                if ($votoExistente->tipo == $tipoNumerico) {
                    $sqlDel = "DELETE FROM {$tabela} WHERE id = :id";
                    $this->pdo->prepare($sqlDel)->execute(['id' => $votoExistente->id]);
                } else {
                    $sqlUpd = "UPDATE {$tabela} SET tipo = :t WHERE id = :id";
                    $this->pdo->prepare($sqlUpd)->execute([
                        't' => $tipoNumerico,
                        'id' => $votoExistente->id
                    ]);
                }
            } else {
                $sqlIns = "INSERT INTO {$tabela} (id_usuario, id_comentario, tipo) VALUES (:user, :comentario, :t)";
                $this->pdo->prepare($sqlIns)->execute([
                    'user' => $idUsuario,
                    'comentario' => $idComentario,
                    't' => $tipoNumerico
                ]);
            }

            $totais = $this->buscarTotaisComentario($idComentario);
            
            $this->pdo->commit();
            return $totais;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e; 
        }
    }

    public function buscarTotaisComentario($idComentario)
    {
        $tabela = 'interacoes_comentarios';
        
        $stmtLikes = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabela} WHERE id_comentario = ? AND tipo = 1");
        $stmtLikes->execute([$idComentario]);
        $totalLikes = $stmtLikes->fetchColumn();

        $stmtDislikes = $this->pdo->prepare("SELECT COUNT(*) FROM {$tabela} WHERE id_comentario = ? AND tipo = 2");
        $stmtDislikes->execute([$idComentario]);
        $totalDislikes = $stmtDislikes->fetchColumn();

        $resultado = new stdClass();
        $resultado->likes = $totalLikes;
        $resultado->dislikes = $totalDislikes;
        return $resultado;
    }

    public function verificarVotoComentario($idUsuario, $idComentario)
    {
        $tabela = 'interacoes_comentarios';
        $sql = "SELECT tipo FROM {$tabela} WHERE id_usuario = :user AND id_comentario = :comentario";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user' => $idUsuario, 'comentario' => $idComentario]);
            return $stmt->fetchColumn(); 
        } catch (Exception $e) {
            return false;
        }
    }
}