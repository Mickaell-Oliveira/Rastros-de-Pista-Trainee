<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class PostIndividualController
{
    public function PostIndividual()
    {
        if (!isset($_GET['id'])) {
            die('ID do post não fornecido.');
        }

        $id_post = $_GET['id'];
        $post = App::get('database')->selectById('posts', $id_post);
        $comentarios = App::get('database')->selectWhere('comentarios', ['id_post' => $id_post]);

        return view('site/Pagina_Individual', compact('post', 'comentarios'));
    }

    public function createComentario()
    {
        $parameters = [
            'id_usuario' => 1,
            'id_post' => $_POST['id_post'],
            'data' => date('Y-m-d H:i:s'),
            'comentario' => $_POST['comentario'] ?? null
        ];
                
        App::get('database')->insert('comentarios', $parameters);
        
        header('Location: /postindividual?id=' . $_POST['id_post']);
    }

    public function interagir()
    {
        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);

        if (!$dados) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados inválidos']);
            return;
        }

        $idPost = $dados['id_post'];
        $acao = $dados['tipo'];
        
        $tipoNumerico = ($acao === 'like') ? 1 : 2; 
        
        session_start();
        $idUsuario = $_SESSION['user_id'] ?? 1;

        $postAtualizado = App::get('database')->registrarInteracao($idUsuario, $idPost, $tipoNumerico);

        header('Content-Type: application/json');
        echo json_encode([
            'likes' => $postAtualizado->likes,
            'dislikes' => $postAtualizado->dislikes
        ]);
        exit;
    }
}
?>