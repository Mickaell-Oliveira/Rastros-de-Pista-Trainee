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

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $idUsuarioLogado = $_SESSION['id'] ?? 0;

        $id_post = $_GET['id'];
        $post = App::get('database')->selectById('posts', $id_post);
        
        $autor = App::get('database')->selectById('usuarios', $post->id_usuario);
        $post->foto_autor = $autor->foto ?? 'default.png';

        $comentarios = App::get('database')->selectComentariosPorPost($id_post);
        
        foreach ($comentarios as $comentario) {
            $totaisComent = App::get('database')->buscarTotaisComentario($comentario->id);
            $comentario->likes_count = $totaisComent->likes;
            $comentario->dislikes_count = $totaisComent->dislikes;
            
            $comentario->meu_voto = 0;
            if ($idUsuarioLogado > 0) {
                $comentario->meu_voto = App::get('database')->verificarVotoComentario($idUsuarioLogado, $comentario->id);
            }
        }
        
        $totais = App::get('database')->buscarTotaisInteracao($id_post); 
        
        $post->likes_count = $totais->likes;
        $post->dislikes_count = $totais->dislikes;
        
        $votoUsuario = 0; 
        if ($idUsuarioLogado > 0) {
            $votoUsuario = App::get('database')->verificarVotoUsuario($idUsuarioLogado, $id_post);
        }

        return view('site/Pagina_Individual', compact('post', 'comentarios', 'votoUsuario'));
    }

    public function createComentario()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id'])) {
            header('Location: /login'); 
            exit;
        }

        $parameters = [
            'id_usuario' => $_SESSION['id'],
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

        if (session_status() === PHP_SESSION_NONE) {
             session_start();
        }

        if (!isset($_SESSION['id'])) {
             http_response_code(401);
             echo json_encode(['erro' => 'Login necessário']);
             return;
        }

        $idPost = $dados['id_post'];
        $acao = $dados['tipo'];
        $tipoNumerico = ($acao === 'like') ? 1 : 2; 
        
        $idUsuario = $_SESSION['id'];

        try {
            $postAtualizado = App::get('database')->registrarInteracao($idUsuario, $idPost, $tipoNumerico);

            header('Content-Type: application/json');
            echo json_encode([
                'likes' => $postAtualizado->likes,
                'dislikes' => $postAtualizado->dislikes
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => $e->getMessage()]);
        }
        exit;
    }

    public function interagirComentario()
    {
        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);

        if (!$dados) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados inválidos']);
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
             session_start();
        }

        if (!isset($_SESSION['id'])) {
             http_response_code(401);
             echo json_encode(['erro' => 'Login necessário']);
             return;
        }

        $idComentario = $dados['id_comentario'];
        $acao = $dados['tipo'];
        $tipoNumerico = ($acao === 'like') ? 1 : 2; 
        
        $idUsuario = $_SESSION['id'];

        try {
            $atualizado = App::get('database')->registrarInteracaoComentario($idUsuario, $idComentario, $tipoNumerico);

            header('Content-Type: application/json');
            echo json_encode([
                'likes' => $atualizado->likes,
                'dislikes' => $atualizado->dislikes
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => $e->getMessage()]);
        }
        exit;
    }
}