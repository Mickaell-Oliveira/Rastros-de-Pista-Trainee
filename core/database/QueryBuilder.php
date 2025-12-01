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

<<<<<<< HEAD
    public function verificaLogin($email, $senha)
        {
            $sql = sprintf(format: 'SELECT * FROM usuarios WHERE email = :email AND senha = :senha');

            try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email,
                'senha' => $senha
            ]);

            $user = $stmt -> fetch(PDO::FETCH_OBJ);
            return $user;

=======
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
>>>>>>> crud_posts_backend

        } catch (Exception $e) {
            die($e->getMessage());
        }
<<<<<<< HEAD
        }
    
}
=======
    }

    public function delete($table, $id)
    {
        $sql = sprintf('DELETE FROM %s   WHERE %s',
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
}

?>
>>>>>>> crud_posts_backend
