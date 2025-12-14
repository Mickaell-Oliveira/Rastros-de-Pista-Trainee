<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class AdminController
{
    public function index()
    { 
        $page = 1; 
        if(isset($_GET['paginacaoNumero']) && !empty($_GET['paginacaoNumero'])){
            $page = intval($_GET['paginacaoNumero']);
            if($page <= 0){
                return redirect('admin/PostChart');
            }
        }
        $itensPage = 5;
        $inicio = $itensPage * $page - $itensPage;

        $rows_count = App::get('database')->countAll('posts');

        if($inicio > $rows_count && $rows_count > 0){
            return redirect('admin/PostChart');
        }
        $posts = App::get('database')->selectAll('posts', $inicio, $itensPage);
        $total_pages = ceil($rows_count/$itensPage);
        $comentarios = App::get('database')->selectAllComentariosComNomes();
        
        return view('admin/PostChart', compact('posts', 'page', 'total_pages', 'comentarios'));
    }

    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit;
        }

        $usuarioLogado = App::get('database')->selectOne('usuarios', $_SESSION['id']);
        
        if (!$usuarioLogado) {
            $nomeAutor = 'Admin'; 
        } else {
            $usuarioLogado = (array) $usuarioLogado;
            $nomeAutor = $usuarioLogado['nome'] ?? 'Admin';
        }

        $caminhodaimagem = 'public/assets/imagemPosts/default.jpg';

        if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
            $temporario = $_FILES['foto']['tmp_name'];
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            
            $nomeimagem = sha1(uniqid($_FILES['foto']['name'], true)) . "." . $extensao;
            $caminhodaimagem = "public/assets/imagemPosts/" . $nomeimagem;

            move_uploaded_file($temporario, $caminhodaimagem);
        }
        
        $parameters = [
            'veiculo'     => $_POST['veiculo'] ?? null,
            'ano_veiculo' => $_POST['ano_veiculo'] ?? null,
            'titulo'      => $_POST['titulo'] ?? null,
            'descricao'   => $_POST['descricao'] ?? null,
            'categoria'   => $_POST['post-tipo'] ?? null,
            'id_usuario'  => $_SESSION['id'], 
            'autor'       => $nomeAutor,
            'data'        => date('Y-m-d H:i:s'),
            'foto'        => $caminhodaimagem,
            'marca'       => $_POST['marca'] ?? null
        ];

        App::get('database')->insert('posts', $parameters);
     
        header('Location: /tabelaposts');
    }

    public function delete()
    {
        $id = $_POST['id'];
        $post = App::get('database')->selectOne('posts', $id);
        
        $post = (object) $post;
        $caminhodaimagem = $post->foto; 

        if(file_exists($caminhodaimagem) && !str_contains($caminhodaimagem, 'default')){
             unlink($caminhodaimagem);
        }

        App::get('database')->delete('posts', $id);
        
        header('Location: /tabelaposts');
    }
      
    public function edit()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        $id = $_POST['id'];
        
        $postAtual = App::get('database')->selectOne('posts', $id);
        $postAtual = (object) $postAtual;
        $caminhodaimagem = $postAtual->foto; 

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $temporario = $_FILES['foto']['tmp_name'];
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

            $nomeimagem = sha1(uniqid($_FILES['foto']['name'], true)) . "." . $extensao;
            $caminhodaimagem = "public/assets/imagemPosts/" . $nomeimagem;
            move_uploaded_file($temporario, $caminhodaimagem);
        }

        $parameters = [
            'veiculo'     => $_POST['veiculo'] ?? null,
            'ano_veiculo' => $_POST['ano_veiculo'] ?? null,
            'titulo'      => $_POST['titulo'] ?? null,
            'descricao'   => $_POST['descricao'] ?? null,
            'categoria'   => $_POST['post-tipo'] ?? null,
            'id_usuario'  => $_SESSION['id'], 
            'autor'       => $_POST['autor'],
            'data'        => date('Y-m-d H:i:s'),
            'foto'        => $caminhodaimagem,
            'marca'       => $_POST['marca'] ?? null
        ];

        App::get('database')->update('posts', $id, $parameters);
        header('Location: /tabelaposts');
    }

    public function updateComment()
    {
        $id = $_POST['id_comentario'];
        $texto = $_POST['novo_texto'];

        App::get('database')->update('comentarios', $id, [
            'comentario' => $texto
        ]);

        header('Location: /tabelaposts');
    }

    public function deleteComment()
    {   
        $id = $_POST['id'];
        App::get('database')->delete('comentarios', $id);
        http_response_code(200);
    }
} 
?>